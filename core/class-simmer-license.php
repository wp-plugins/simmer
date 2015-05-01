<?php
/**
 * Define the license handler class
 *
 * @since 1.0.0
 *
 * @package Simmer/License
 */
 
// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The class that handles Simmer's licensing.
 * 
 * @since 1.0.2
 */
final class Simmer_License {
	
	/**
	 * The URL for the Simmer API.
	 * 
	 * @since 1.0.2
	 * 
	 * @var string $api_url The URL for the Simmer API.
	 */
	public $api_url;
	
	/**
	 * The WooCommerce product ID.
	 * 
	 * @since 1.0.2
	 * 
	 * @var string $product_id The WooCommerce product ID.
	 */
	public $product_id;
	
	/**
	 * The client site's domain.
	 * 
	 * @since 1.0.2
	 * 
	 * @var string $domain The client site's domain.
	 */
	public $domain;
	
	/**
	 * The Simmer install's license instance.
	 * 
	 * @since 1.0.2
	 * 
	 * @var string $instance The Simmer install's license instance.
	 */
	public $instance;
	
	/**
	 * The current Simmer license information.
	 * 
	 * @since 1.0.2
	 * 
	 * @var string $license The current Simmer license information.
	 */
	public $license;
	
	/**
	 * Construct the class.
	 * 
	 * @since 1.0.2
	 */
	public function __construct() {
		
		$this->api_url = 'https://simmerwp.com/';
		
		$this->product_id = 'Simmer';
		
		$this->domain = str_ireplace( array( 'http://', 'https://' ), '', site_url() );
		
		$this->instance = get_option( 'simmer_license_instance' );
		
		// If the current site doesn't yet have an instance, generate one.
		if ( ! $this->instance ) {
			
			$this->instance = wp_generate_password( 12, false );
			
			add_option( 'simmer_license_instance', $this->instance, false );
		}
		
		$this->license = get_option( 'simmer_license' );
		$this->key     = ( isset( $this->license['key']   ) ) ? $this->license['key']   : false;
		$this->email   = ( isset( $this->license['email'] ) ) ? $this->license['email'] : false;
	}
	
	/**
	 * Generate the API request URL.
	 * 
	 * @since 1.0.2
	 * 
	 * @param  array  $args    The query arguments to add to the URL.
	 * @return string $api_url The built API request URL.
	 */
	public function get_api_url( $args ) {
		
		// Add the WooCommerce API endpoint to the request.
		$api_url = add_query_arg( 'wc-api', 'am-software-api', $this->api_url );
		
		// Add the arguments.
		$api_url = $api_url . '&' . http_build_query( $args );
		
		return $api_url;
	}
	
	/**
	 * Get the current Simmer license status.
	 * 
	 * @since 1.0.2
	 * 
	 * @param  array       $args   Optional. Override arguments to pass with the request.
	 * @return string|bool $status The text status of the license.
	 */
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
	
	/**
	 * Attempt to activate a new license.
	 * 
	 * @since 1.0.2
	 * 
	 * @param  array $args     Optional. Override arguments to pass with the request.
	 * @return array $response The Simmer API's response.
	 */
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
	
	/**
	 * Attempt to deactivate the current license.
	 * 
	 * @since 1.0.2
	 * 
	 * @param  array $args     Optional. Override arguments to pass with the request.
	 * @return array $response The Simmer API's response.
	 */
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
	
	/**
	 * Determine if a valid license exists on simmerwp.com.
	 * 
	 * @since 1.0.2
	 * 
	 * @return bool $exists Whether the current license information exists on simmerwp.com.
	 */
	public function exists() {
		
		$exists = (bool) $this->get_status();
		
		return $exists;
	}
	
	/**
	 * Determine if the current license is active.
	 * 
	 * @since 1.0.2
	 * 
	 * @return bool $is_active Whether the current license information matches an active license on simmerwp.com.
	 */
	public function is_active() {
		
		$is_active = false;
		
		$status = $this->get_status();
		
		if ( 'active' == $status ) {
			$is_active = true;
		}
		
		return $is_active;
	}
	
	/**
	 * Determine if communication with the Simmer API is being blocked.
	 * 
	 * @since 1.0.2
	 * 
	 * @return bool Whether communication with the Simmer API is being blocked.
	 */
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
