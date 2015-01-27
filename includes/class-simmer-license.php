<?php
/**
 * Define the license manager class
 *
 * @since 1.0.0
 *
 * @package Simmer\License
 */
 
// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Simmer_License {
	
	public $api_url;
	
	public $product_id;
	
	public $domain;
	
	public $instance;
	
	public $license;
	
	public function __construct() {
		
		$this->api_url = 'http://simmerwp.com/';
		
		$this->product_id = 'Simmer';
		
		$this->domain = str_ireplace( array( 'http://', 'https://' ), '', site_url() );
		
		$this->instance = get_option( 'simmer_license_instance' );
		
		if ( ! $this->instance ) {
			
			$this->instance = wp_generate_password( 12, false );
			
			add_option( 'simmer_license_instance', $this->instance, false );
		}
		
		$this->license = get_option( 'simmer_license' );
		$this->key     = ( isset( $this->license['key']   ) ) ? $this->license['key']   : false;
		$this->email   = ( isset( $this->license['email'] ) ) ? $this->license['email'] : false;
	}
	
	public function get_api_url( $args ) {
		
		$api_url = add_query_arg( 'wc-api', 'am-software-api', $this->api_url );

		return $api_url . '&' . http_build_query( $args );
	}
	
	public function get_status( $args = array() ) {
		
		$defaults = array(
			'request'     => 'status',
			'product_id'  => $this->product_id,
			'platform'    => $this->domain,
			'instance'    => $this->instance,
			'licence_key' => $this->key,
			'email'       => $this->email,
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = $this->get_api_url( $args );

		$request = wp_remote_get( $target_url );

		if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );
		
		$response = json_decode( $response );
		
		if ( isset( $response->status_check ) ) {
			
			$status = 'active';
			
		} else if ( isset( $response->code ) && '106' == $response->code ) {
			
			$status = 'inactive';
			
		} else {
			
			$status = false;
			
		}
		
		return $status;
	}
	
	public function activate( $args ) {
		
		$defaults = array(
			'request'    => 'activation',
			'product_id' => $this->product_id,
			'platform'   => $this->domain,
			'instance'   => $this->instance,
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = $this->get_api_url( $args );

		$request = wp_remote_get( $target_url );

		if ( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );
		
		$response = json_decode( $response, true );
		
		return $response;
	}

	public function deactivate( $args ) {

		$defaults = array(
			'request'    => 'deactivation',
			'product_id' => $this->product_id,
			'platform'   => $this->domain,
			'instance'   => $this->instance,
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = $this->get_api_url( $args );

		$request = wp_remote_get( $target_url );

		if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );
		
		$response = json_decode( $response, true );
		
		return $response;
	}
	
	public function exists() {
		
		$exists = (bool) $this->get_status();
		
		return $exists;
	}
	
	public function is_active() {
		
		$is_active = false;
		
		$status = $this->get_status();
		
		if ( 'active' == $status ) {
			$is_active = true;
		}
		
		return $is_active;
	}
	
	public function is_blocked() {
		
		if ( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) && WP_HTTP_BLOCK_EXTERNAL === true ) {

			$host = parse_url( $this->api_url, PHP_URL_HOST );

			if ( ! defined( 'WP_ACCESSIBLE_HOSTS' ) || stristr( WP_ACCESSIBLE_HOSTS, $host ) === false ) {
				return true;
			}

		}
		
		return false;
	}
}
