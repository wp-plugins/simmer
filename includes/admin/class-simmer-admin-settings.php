<?php
/**
 * Define he settings admin class
 *
 * @since 1.0.0
 *
 * @package Simmer\Admin\Settings
 */
 
// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Simmer_Admin_Settings {
	
	/**
	 * Construct this class.
	 *
	 * @since 1.0.0
	 * @access private
	 * 
	 * @return void
	 */
	public function __construct() {
		
		// Add the settings submenu item.
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		
		// Register the available settings with the Settings API.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Add the Recipes settings page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function add_options_page() {
		
		add_submenu_page(
			'edit.php?post_type=recipe',
			__( 'Extend', Simmer::SLUG ),
			__( 'Extend', Simmer::SLUG ),
			'manage_options',
			'simmer-extend',
			array( $this, 'extend_page_callback' )
		);
		
		add_options_page(
			__( 'Recipes', Simmer::SLUG ),
			__( 'Recipes', Simmer::SLUG ),
			'manage_options',
			'simmer-settings',
			array( $this, 'settings_page_callback' )
		);
	}
	
	/**
	 * Register the settings.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_settings() {
		
		/* Display */
		
		// Add the ingredients display settings section.
		add_settings_section(
			'simmer_display_ingredients',
			__( 'Ingredients', Simmer::SLUG ),
			'__return_false',
			'simmer_display'
		);
		
		// Register the ingredients display settings.
		register_setting( 'simmer_display', 'simmer_ingredients_list_heading', 'esc_html' );
		register_setting( 'simmer_display', 'simmer_ingredients_list_type',    'esc_attr' );
		register_setting( 'simmer_display', 'simmer_units_format',             'esc_attr' );
		
		// Add the ingredients display settings fields.
		add_settings_field(
			'simmer_ingredients_list_heading',
			__( 'List Heading', Simmer::SLUG ),
			array( $this, 'ingredients_list_heading_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		add_settings_field(
			'simmer_ingredients_list_type',
			__( 'List Type', Simmer::SLUG ),
			array( $this, 'ingredients_list_type_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		add_settings_field(
			'simmer_units_format',
			__( 'Show Units As', Simmer::SLUG ),
			array( $this, 'units_format_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		
		// Add the instructions display settings section.
		add_settings_section(
			'simmer_display_instructions',
			__( 'Instructions', Simmer::SLUG ),
			'__return_false',
			'simmer_display'
		);
		
		// Register the instructions display settings.
		register_setting( 'simmer_display', 'simmer_instructions_list_heading', 'esc_html' );
		register_setting( 'simmer_display', 'simmer_instructions_list_type',    'esc_attr' );
		
		// Add the instructions display settings fields.
		add_settings_field(
			'simmer_instructions_list_heading',
			__( 'List Heading', Simmer::SLUG ),
			array( $this, 'instructions_list_heading_callback' ),
			'simmer_display',
			'simmer_display_instructions'
		);
		add_settings_field(
			'simmer_instructions_list_type',
			__( 'List Type', Simmer::SLUG ),
			array( $this, 'instructions_list_type_callback' ),
			'simmer_display',
			'simmer_display_instructions'
		);
	 	
	 	// Add the styles display settings section.
		add_settings_section(
			'simmer_display_styles',
			__( 'Styles', Simmer::SLUG ),
			'__return_false',
			'simmer_display'
		);
		
		// Register the general display settings.
		register_setting( 'simmer_display', 'simmer_enqueue_styles', 'absint' );
		register_setting( 'simmer_display', 'simmer_recipe_accent_color', array( $this, 'validate_hex_color' ) );
		register_setting( 'simmer_display', 'simmer_recipe_text_color', array( $this, 'validate_hex_color' ) );
		
		// Add the general display settings fields.
		add_settings_field(
			'simmer_enqueue_styles',
			__( 'Enable Styles', Simmer::SLUG ),
			array( $this, 'enqueue_styles_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		add_settings_field(
			'simmer_recipe_accent_color',
			__( 'Accent Color', Simmer::SLUG ),
			array( $this, 'recipe_accent_color_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		add_settings_field(
			'simmer_recipe_text_color',
			__( 'Text Color', Simmer::SLUG ),
			array( $this, 'recipe_text_color_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		
		/** License **/
		
		// Add the license settings section.
		add_settings_section(
			'simmer_license_add',
			__( 'License Information', Simmer::SLUG ),
			'__return_false',
			'simmer_license'
		);
		
		register_setting( 'simmer_license', 'simmer_license', array( $this, 'validate_license_input' ) );
		
		// Add the license settings fields.
		add_settings_field(
			'simmer_license_key',
			__( 'License Key', Simmer::SLUG ),
			array( $this, 'license_key_callback' ),
			'simmer_license',
			'simmer_license_add'
		);
		add_settings_field(
			'simmer_license_email',
			__( 'License Email', Simmer::SLUG ),
			array( $this, 'license_email_callback' ),
			'simmer_license',
			'simmer_license_add'
		);
		
		$license = new Simmer_License_Manager();

		if ( $license->is_active() ) {
			
			add_settings_field(
				'simmer_license_deactivate',
				__( 'Deactivate', Simmer::SLUG ),
				array( $this, 'license_deactivate_callback' ),
				'simmer_license',
				'simmer_license_add'
			);
			
		}
		
		/** Advanced **/
		
		/** Permalinks **/
	 	
	 	// Add the "Recipes" section to the WordPress permalink options page.
		add_settings_section(
			'simmer_permalinks',
			__( 'Permalinks', Simmer::SLUG ),
			'__return_false',
			'simmer_advanced'
		);
	 	
	 	// Register the permalink settings.
	 	register_setting( 'simmer_advanced', 'simmer_archive_base',  'esc_attr' );
	 	register_setting( 'simmer_advanced', 'simmer_recipe_base',   'esc_attr' );
	 	register_setting( 'simmer_advanced', 'simmer_category_base', 'esc_attr' );
	 	
	 	// Define the fields.
	 	add_settings_field(
	 		'simmer_archive_base',
	 		__( 'Archive base', Simmer::SLUG ),
	 		array( $this, 'archive_base_callback' ),
	 		'simmer_advanced',
	 		'simmer_permalinks'
	 	);
		add_settings_field(
			'simmer_recipe_base',
			__( 'Single recipe base', Simmer::SLUG ),
			array( $this, 'recipe_base_callback' ),
			'simmer_advanced',
			'simmer_permalinks'
		);
		add_settings_field(
			'simmer_category_base',
			__( 'Category base', Simmer::SLUG ),
			array( $this, 'category_base_callback' ),
			'simmer_advanced',
			'simmer_permalinks'
		);
		
		// Add the uninstall settings section.
		add_settings_section(
			'simmer_advanced_uninstall',
			__( 'Uninstall Settings', Simmer::SLUG ),
			'__return_false',
			'simmer_advanced'
		);
		
		register_setting( 'simmer_advanced', 'simmer_on_uninstall', 'esc_attr' );
		
		// Add the on uninstall settings field.
		add_settings_field(
			'simmer_on_uninstall',
			__( 'On Uninstall', Simmer::SLUG ),
			array( $this, 'on_uninstall_callback' ),
			'simmer_advanced',
			'simmer_advanced_uninstall'
		);
		
		/**
		 * Allow others to register additional Simmer settings.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_register_settings' );
		
	}
	
	public function enqueue_styles() {
		
		wp_enqueue_style(  'wp-color-picker' );
	}
	
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'simmer-plugin-settings-scripts', plugin_dir_url( __FILE__ ) . 'assets/settings.js', array(
			'jquery',
			'wp-color-picker'
		), Simmer::VERSION );
	}
	
	/**
	 * Display the extend page markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function extend_page_callback() {
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/extend-page.php' );
	}
	
	/**
	 * Display the settings page markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function settings_page_callback() {
		
		// Define the settings tabs.
		$tabs = array(
			'display'  => __( 'Display',  Simmer::SLUG ),
			#'license'  => __( 'License',  Simmer::SLUG ),
			'advanced' => __( 'Advanced', Simmer::SLUG ),
		);
		
		/**
		 * Filter the settings page tabs.
		 * 
		 * @since 1.0.0
		 * 
		 * @param array $tabs The default settings page tabs.
		 */
		$tabs = apply_filters( 'simmer_settings_tabs', $tabs );
		
		// Get current tab.
		$current_tab = empty( $_GET['tab'] ) ? 'display' : sanitize_title( $_GET['tab'] );
		
		// Flush the rewrite rules.
		if ( 'advanced' == $current_tab ) {
			flush_rewrite_rules();
		}
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/settings-page.php' );
	}
	
	/**
	 * Display the Ingredients List Heading setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function ingredients_list_heading_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_ingredients_list_heading_setting_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/ingredients-list-heading.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_ingredients_list_heading_setting_field' );
	}
	
	/**
	 * Display the Ingredients List Type setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function ingredients_list_type_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_ingredients_list_type_setting_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/ingredients-list-type.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_ingredients_list_type_setting_field' );
	}
	
	/**
	 * Display the units format settings field markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function units_format_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_units_format_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/units-format.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_units_format_settings_field' );
	}
	
	/**
	 * Display the Instructions List Heading setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function instructions_list_heading_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_instructions_list_heading_setting_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/instructions-list-heading.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_ingredients_list_heading_setting_field' );
	}
	
	/**
	 * Display the Instructions List Type setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function instructions_list_type_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_instructions_list_type_setting_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/instructions-list-type.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_instructions_list_type_setting_field' );
	}
	
	/**
	 * Display the "enqueue styles" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function enqueue_styles_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_enqueue_styles_setting_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/enqueue-styles.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_enqueue_styles_setting_field' );
	}
	
	/**
	 * Display the "recipe accent color" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function recipe_accent_color_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_recipe_accent_color_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/recipe-accent-color.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_recipe_accent_color_settings_field' );
	}
	
	/**
	 * Display the "recipe text color" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function recipe_text_color_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_recipe_text_color_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/recipe-text-color.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_recipe_text_color_settings_field' );
	}
	
	/**
	 * Display the "license key" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function license_key_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_license_key_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/license-key.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_license_key_settings_field' );
	}
	
	/**
	 * Display the "license email" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function license_email_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_license_email_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/license-email.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_license_email_settings_field' );
	}
	
	/**
	 * Display the "deactivate license" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function license_deactivate_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_license_deactivate_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/license-deactivate.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_license_deactivate_settings_field' );
	}
	
	/**
	 * Display the "on uninstall" setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function on_uninstall_callback() {
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_on_uninstall_settings_field' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/advanced/on-uninstall.php' );
		
		/**
		 * Allow others to add to this field.
		 * 
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_on_uninstall_settings_field' );
	}
	
	/**
	 * Display the Archive Base setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function archive_base_callback() {
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/permalink-archive-base.php' );
	}
	
	/**
	 * Display the Recipe Base setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function recipe_base_callback() {
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/permalink-recipe-base.php' );
	}
	
	/**
	 * Display the Category Base setting markup.
	 * 
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function category_base_callback() {
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/permalink-category-base.php' );
	}
	
	/**
	 * Validate a given hex color.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string $color A color in hex format.
	 * @return string $color A color in hex format or empty on failure.
	 */
	public function validate_hex_color( $color ) {
		
		$color = preg_replace( '/[^0-9a-fA-F]/', '', $color );
		
		if ( strlen( $color ) == 6 || strlen( $color ) == 3 ) {
			return $color;
		} else {
			return '';
		}
	}
	
	/**
	 * Validate the license settings.
	 * 
	 * @since 1.0.0
	 * 
	 * @param  array $input The license settings field input.
	 * @return array $license
	 */
	public function validate_license_input( $input ) {
		
		$license_manager = new Simmer_License_Manager();
		
		$current_license = get_option( 'simmer_license' );
		
		$current_key   = ( isset( $current_license['key'] ) ) ? trim( $current_license['key'] ) : false;
		$current_email = ( isset( $current_license['email'] ) && is_email( $current_license['email'] ) ) ? trim( $current_license['email'] ) : false;
		
		if ( isset( $input['deactivate'] ) && 1 == $input['deactivate'] ) {
			
			$license_manager->deactivate( array(
				'licence_key' => $current_key,
				'email'       => $current_email,
				'instance'    => $current_license['instance'],
			) );
			
			add_settings_error( 'simmer_license', 'simmer-deactivated', __( 'License deactivated.', Simmer::SLUG ), 'error' );
			
			return false;
			
		} else {
			
			$new_license = $input;
			
			$new_key   = ( isset( $new_license['key'] ) ) ? trim( $new_license['key'] ) : false;
			$new_email = ( isset( $new_license['email'] ) && is_email( $new_license['email'] ) ) ? trim( $new_license['email'] ) : false;
			
			$license = array();
			
			if ( isset( $current_license['instance'] ) ) {
				$license['instance'] = $current_license['instance'];
			} else {
				$license['instance'] = wp_generate_password( 12, false );
			}
			
			if ( $current_key && ( $new_key != $current_key ) ) {
				
				$license_manager->deactivate( array(
					'licence_key' => $current_key,
					'email'       => $current_email,
					'instance'    => $license['instance'],
				) );
				
			}
			
			$results = $license_manager->activate( array(
				'licence_key' => $new_key,
				'email'       => $new_email,
				'instance'    => $license['instance'],
			) );
			
			$results = json_decode( $results, true );
			
			if ( false == $results ) {
				
				add_settings_error( 'api_key_check_text', 'api_key_check_error', __( 'Connection failed to the License Key API server. Try again later.', Simmer::SLUG ), 'error' );
				
				$license['key']   = '';
				$license['email'] = '';
				
				return $license;
			}
			
			if ( isset( $results['activated'] ) && 1 == $results['activated'] ) {
				
				$license['key']   = $new_key;
				$license['email'] = $new_email;
				
				add_settings_error( 'simmer_license', 'simmer-activated', __( 'License activated.', Simmer::SLUG ), 'updated' );
				
				return $license;
				
			} else if ( isset( $results['code'] ) ) {
		
				switch ( $results['code'] ) {
					
					case '100':
						
						add_settings_error( 'api_email_text', 'api_email_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '101':
						
						add_settings_error( 'api_key_text', 'api_key_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '102':
						
						add_settings_error( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '103':
						
						add_settings_error( 'api_key_exceeded_text', 'api_key_exceeded_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '104':
						
						add_settings_error( 'api_key_not_activated_text', 'api_key_not_activated_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '105':
						
						add_settings_error( 'api_key_invalid_text', 'api_key_invalid_error', "{$results['error']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
					
					case '106':
						
						add_settings_error( 'sub_not_active_text', 'sub_not_active_error', "{$results['error']}. {$results['additional info']}", 'error' );
						
						$license['key']   = '';
						$license['email'] = '';
						
					break;
				}
		
			}
			
			return $license;
			
		}
	}
}

new Simmer_Admin_Settings();
