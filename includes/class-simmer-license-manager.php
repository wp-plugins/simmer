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

final class Simmer_License_Manager {
	
	var $api_url;
	
	var $product_id;
	
	var $platform;
	
	public function __construct() {
		
		$this->api_url = 'http://simmerwp.com/';
		
		$this->product_id = 'Simmer';
		
		$this->platform = site_url();
		
	}
	
	public function create_software_api_url( $args ) {
		
		$api_url = add_query_arg( 'wc-api', 'am-software-api', $this->api_url );

		return $api_url . '&' . http_build_query( $args );
	}

	public function activate( $args ) {
		
		$defaults = array(
			'request'    => 'activation',
			'product_id' => $this->product_id,
			'platform'   => $this->platform,
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = self::create_software_api_url( $args );

		$request = wp_remote_get( $target_url );

		if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );

		return $response;
	}

	public function deactivate( $args ) {

		$defaults = array(
			'request'    => 'deactivation',
			'product_id' => $this->product_id,
			'platform'   => $this->platform
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = self::create_software_api_url( $args );

		$request = wp_remote_get( $target_url );

		if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );

		return $response;
	}

	public function is_active( $args = array() ) {
		
		$license = get_option( 'simmer_license' );
		
		$defaults = array(
			'request'    => 'status',
			'product_id' => $this->product_id,
			'platform'   => $this->platform,
			'licence_key' => ( isset( $license['key'] ) ) ? $license['key'] : '',
			'email'       => ( isset( $license['email'] ) ) ? $license['email'] : '',
			'instance'    => ( isset( $license['instance'] ) ) ? $license['instance'] : '',
		);

		$args = wp_parse_args( $defaults, $args );

		$target_url = self::create_software_api_url( $args );

		$request = wp_remote_get( $target_url );

		if( is_wp_error( $request ) || wp_remote_retrieve_response_code( $request ) != 200 ) {
			return false;
		}

		$response = wp_remote_retrieve_body( $request );
		
		$response = json_decode( $response );
	
		if ( 'active' == $response->status_check ) {
			return $response;
		} else {
			return false;
		}
	}
}
