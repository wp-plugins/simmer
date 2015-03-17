<?php
/**
 * Define the plugin activation class
 * 
 * @since 1.0.2
 * 
 * @package Simmer/Activation
 */

/**
 * The class for defining plugin activation/deactivation tasks.
 * 
 * @since 1.0.2
 */
final class Simmer_Activation {
	
	/**
	 * Set up the plugin database version number & blank license on activation.
	 * 
	 * @since 1.0.2
	 */
	public static function activate() {
		
		// Add a blank license by default.
		update_option( 'simmer_license', '' );
		
		$installed_version = get_option( 'simmer_version' );
		
		// Update the version number in the database.
		if ( version_compare( Simmer::VERSION, $installed_version, '>' ) ) {
			update_option( 'simmer_version', Simmer::VERSION );
		}
	}
	
	/**
	 * Remove the license information on deactivation.
	 * 
	 * @since 1.0.2
	 */
	public static function deactivate() {
		
		// Remove any license information.
		delete_option( 'simmer_license' );
		
	}
}
