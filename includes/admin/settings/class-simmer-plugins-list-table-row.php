<?php
/**
 * Define the plugins list table row customizing class
 * 
 * @since 1.0.3
 * 
 * @package Simmer\Admin
 */

// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Plugins_List_Table_Row {
	
	/**
	 * The only instance of this class.
	 *
	 * @since  1.0.3
	 * @access private
	 * @var    object The only instance of this class.
	 */
	private static $instance = null;
	
	/**
	 * The base plugin file path.
	 *
	 * @since  1.0.3
	 * @access private
	 * @var    string The base plugin file path.
	 */
	private $plugin_file;
	
	/**
	 * Get the main instance.
	 *
	 * Insure that only one instance of this class exists in memory at any one time.
	 *
	 * @since 1.0.3
	 *
	 * @return The only instance of this class.
	 */
	public static function get_instance() {
		
		if ( is_null( self::$instance ) ) {
			
			self::$instance = new self();
			
			self::$instance->add_actions();
		}
		
		return self::$instance;
	}
	
	/**
	 * Set up the variables.
	 * 
	 * @since 1.0.3
	 */
	public function __construct() {
		
		$this->plugin_file = SIMMER_PLUGIN_FILE;
	}
	
	/**
	 * Add the necessary actions.
	 * 
	 * @since 1.0.3
	 */
	private function add_actions() {
		
		// Add a settings link to the list of plugin row actions.
		add_action( 'plugin_action_links_' . $this->plugin_file, array( $this, 'add_settings_link' ) );
	}
	
	/**
	 * Add a settings link to the list of plugin row actions.
	 * 
	 * @since 1.0.3
	 * 
	 * @param  array $actions The default plugin row actions.
	 * @return array $actions The new plugin row actions.
	 */
	public function add_settings_link( $actions ) {
		
		$new_action = sprintf(
			'<a href="%s">%s</a>',
			esc_url( get_admin_url( null, 'options-general.php?page=simmer-settings' ) ),
			__( 'Settings', Simmer::SLUG )
		);
		
		// Add the new action to the front of the array.
		array_unshift( $actions, $new_action );
		
		return $actions;
	}
}
