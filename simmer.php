<?php
/**
 * The plugin bootstrap
 *
 * @link http://simmerwp.com
 * @since 1.0.0
 * @package Simmer
 */

/**
 * Plugin Name: Simmer
 * Plugin URI:  http://simmerwp.com
 * Description: A recipe plugin for WordPress.
 * Version:     1.2.0
 * Author:      BWD inc.
 * Author URI:  http://gobwd.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: simmer
 * Domain Path: /languages
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/** Constants **/

/**
 * The base plugin file path (this file).
 *
 * @since 1.0.3
 * @var string SIMMER_PLUGIN_FILE The base plugin file path.
 */
define( 'SIMMER_PLUGIN_FILE', plugin_basename( __FILE__ ) );

/**
 * Load the main activation class definition.
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-simmer-activation.php' );

register_activation_hook( __FILE__, 'Simmer_Activation::activate' );
register_deactivation_hook( __FILE__, 'Simmer_Activation::deactivate' );

/**
 * Load the main Simmer license class definition.
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-simmer-license.php' );

/**
 * Load the main Simmer class definition.
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/class-simmer.php' );

// After all other plugins are loaded, instantiate Simmer.
add_action( 'plugins_loaded', array( 'Simmer', 'get_instance' ) );

/**
 * Require the widgets class definition.
 */
require_once( plugin_dir_path( __FILE__ ) . 'includes/widgets/class-simmer-widgets.php' );

// Init the widgets class.
add_action( 'widgets_init', array( 'Simmer_Widgets', 'get_instance' ) );

// Only do the following when in the admin & not AJAXing something.
if ( is_admin() ) {
	
	/**
	 * Load Simmer's admin class definition.
	 */
	require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/class-simmer-admin.php' );
	
	// After all other plugins are loaded, instantiate the Simmer admin.
	add_action( 'plugins_loaded', array( 'Simmer_Admin', 'get_instance' ) );
	
	/**
	 * Require the plugins list table row customizing class.
	 */
	require_once( plugin_dir_path( __FILE__ ) . 'includes/admin/settings/class-simmer-plugins-list-table-row.php' );
	
	add_action( 'admin_init', array( 'Simmer_Plugins_List_Table_Row', 'get_instance' ) );
}
