<?php
/**
 * Define the settings admin class
 *
 * @since 1.0.0
 *
 * @package Simmer/Admin/Settings
 */
 
// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Set up the setting admin.
 *
 * @since 1.0.0
 */
final class Simmer_Admin_Settings {
	
	/**
	 * Construct settings admin.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		
		// Add the settings submenu item.
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		
		// Register the available settings with the Settings API.
		add_action( 'admin_init', array( $this, 'register_settings' ) );
		
		// Enqueue the admin styles.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		
		// Enqueue the admin scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}
	
	/**
	 * Add the Recipes settings page.
	 *
	 * @since 1.0.0
	 */
	public function add_options_page() {
		
		add_submenu_page(
			'edit.php?post_type=recipe',
			__( 'Extend', Simmer()->domain ),
			__( 'Extend', Simmer()->domain ),
			'manage_options',
			'simmer-extend',
			array( $this, 'extend_page_callback' )
		);
		
		add_options_page(
			__( 'Recipes', Simmer()->domain ),
			__( 'Recipes', Simmer()->domain ),
			'manage_options',
			'simmer-settings',
			array( $this, 'settings_page_callback' )
		);
	}
	
	/**
	 * Register the settings.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		
		/* Display */
		
		// Add the ingredients display settings section.
		add_settings_section(
			'simmer_display_ingredients',
			__( 'Ingredients', Simmer()->domain ),
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
			__( 'List Heading', Simmer()->domain ),
			array( $this, 'ingredients_list_heading_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		add_settings_field(
			'simmer_ingredients_list_type',
			__( 'List Type', Simmer()->domain ),
			array( $this, 'ingredients_list_type_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		add_settings_field(
			'simmer_units_format',
			__( 'Show Units As', Simmer()->domain ),
			array( $this, 'units_format_callback' ),
			'simmer_display',
			'simmer_display_ingredients'
		);
		
		// Add the instructions display settings section.
		add_settings_section(
			'simmer_display_instructions',
			__( 'Instructions', Simmer()->domain ),
			'__return_false',
			'simmer_display'
		);
		
		// Register the instructions display settings.
		register_setting( 'simmer_display', 'simmer_instructions_list_heading', 'esc_html' );
		register_setting( 'simmer_display', 'simmer_instructions_list_type',    'esc_attr' );
		
		// Add the instructions display settings fields.
		add_settings_field(
			'simmer_instructions_list_heading',
			__( 'List Heading', Simmer()->domain ),
			array( $this, 'instructions_list_heading_callback' ),
			'simmer_display',
			'simmer_display_instructions'
		);
		add_settings_field(
			'simmer_instructions_list_type',
			__( 'List Type', Simmer()->domain ),
			array( $this, 'instructions_list_type_callback' ),
			'simmer_display',
			'simmer_display_instructions'
		);
	 	
	 	// Add the styles display settings section.
		add_settings_section(
			'simmer_display_styles',
			__( 'Styles', Simmer()->domain ),
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
			__( 'Enable Styles', Simmer()->domain ),
			array( $this, 'enqueue_styles_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		add_settings_field(
			'simmer_recipe_accent_color',
			__( 'Accent Color', Simmer()->domain ),
			array( $this, 'recipe_accent_color_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		add_settings_field(
			'simmer_recipe_text_color',
			__( 'Text Color', Simmer()->domain ),
			array( $this, 'recipe_text_color_callback' ),
			'simmer_display',
			'simmer_display_styles'
		);
		
		/** License **/
		
		// Add the license settings section.
		add_settings_section(
			'simmer_license_add',
			__( 'Simmer License', Simmer()->domain ),
			array( $this, 'license_section_callback' ),
			'simmer_license'
		);
		
		register_setting( 'simmer_license', 'simmer_license', array( $this, 'validate_license_input' ) );
		
		// Add the license settings fields.
		add_settings_field(
			'simmer_license_key',
			__( 'License Key', Simmer()->domain ),
			array( $this, 'license_key_callback' ),
			'simmer_license',
			'simmer_license_add'
		);
		
		$license = new Simmer_License();

		if ( ! $license->get_status() ) {
				
			add_settings_field(
				'simmer_license_email',
				__( 'License Email', Simmer()->domain ),
				array( $this, 'license_email_callback' ),
				'simmer_license',
				'simmer_license_add'
			);
			
		}
		
		global $simmer_extensions;
		
		if ( ! empty( $simmer_extensions ) ) {
			
			// Add the extensions license settings section.
			add_settings_section(
				'simmer_license_extensions',
				__( 'Extension Licenses', Simmer()->domain ),
				array( $this, 'license_extensions_section_callback' ),
				'simmer_license'
			);
			
		}
		
		/** Advanced **/
		
		/** Permalinks **/
	 	
	 	// Add the "Recipes" section to the WordPress permalink options page.
		add_settings_section(
			'simmer_permalinks',
			__( 'Permalinks', Simmer()->domain ),
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
	 		__( 'Archive base', Simmer()->domain ),
	 		array( $this, 'archive_base_callback' ),
	 		'simmer_advanced',
	 		'simmer_permalinks'
	 	);
		add_settings_field(
			'simmer_recipe_base',
			__( 'Single recipe base', Simmer()->domain ),
			array( $this, 'recipe_base_callback' ),
			'simmer_advanced',
			'simmer_permalinks'
		);
		add_settings_field(
			'simmer_category_base',
			__( 'Category base', Simmer()->domain ),
			array( $this, 'category_base_callback' ),
			'simmer_advanced',
			'simmer_permalinks'
		);
		
		// Add the uninstall settings section.
		add_settings_section(
			'simmer_advanced_uninstall',
			__( 'Uninstall Settings', Simmer()->domain ),
			'__return_false',
			'simmer_advanced'
		);
		
		register_setting( 'simmer_advanced', 'simmer_on_uninstall', 'esc_attr' );
		
		// Add the on uninstall settings field.
		add_settings_field(
			'simmer_on_uninstall',
			__( 'On Uninstall', Simmer()->domain ),
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
	
	/**
	 * Enqueue the admin styles.
	 *
	 * @since x.x.x
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style(  'wp-color-picker' );
	}
	
	/**
	 * Enqueue the admin scripts.
	 *
	 * @since x.x.x
	 */
	public function enqueue_scripts() {
		
		wp_enqueue_script( 'simmer-plugin-settings-scripts', plugin_dir_url( __FILE__ ) . 'assets/settings.js', array(
			'jquery',
			'wp-color-picker'
		), Simmer()->version );
	}
	
	/**
	 * Display the extend page markup.
	 * 
	 * @since 1.0.0
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
	 */
	public function settings_page_callback() {
		
		// Define the settings tabs.
		$tabs = array(
			'display'  => __( 'Display',  Simmer()->domain ),
		);
		
		/**
		 * Filter the settings page tabs.
		 * 
		 * @since 1.0.0
		 * 
		 * @param array $tabs The default settings page tabs.
		 */
		$tabs = apply_filters( 'simmer_settings_tabs', $tabs );
		
		// Append the Licenses tab to the end.
		$tabs['advanced'] = __( 'Advanced',  Simmer()->domain );
		$tabs['license'] = __( 'Licenses',  Simmer()->domain );
		
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
	 * Display the "license" section markup.
	 * 
	 * @since 1.0.0
	 */
	public function license_section_callback() {
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/license-section.php' );
		
	}
	
	/**
	 * Display the "license key" setting markup.
	 * 
	 * @since 1.0.0
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
	 * Display the "extensions license" section markup.
	 * 
	 * @since 1.0.0
	 */
	public function license_extensions_section_callback() {
		
		do_action( 'simmer_before_license_extensions_section' );
		
		/**
		 * Include the markup.
		 */
		include_once( 'html/settings/license-extensions-section.php' );
		
		do_action( 'simmer_after_license_extensions_section' );
		
	}
	
	/**
	 * Display the "on uninstall" setting markup.
	 * 
	 * @since 1.0.0
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
		
		$license = new Simmer_License();
		
		$existing_license  = $license->license;
		
		$existing_key      = ( isset( $existing_license['key'] ) )   ? trim( $existing_license['key'] )   : '';
		$existing_email    = ( isset( $existing_license['email'] ) ) ? trim( $existing_license['email'] ) : '';
		
		if ( isset( $input['deactivate'] ) && '1' == $input['deactivate'] ) {
			
			$result = $license->deactivate( array(
				'licence_key' => $existing_key,
				'email'       => $existing_email,
			) );
			
			add_settings_error( 'simmer_license', 'simmer-deactivated', __( 'License deactivated.', Simmer()->domain ), 'error' );
			
			return false;
			
		} else if ( $license->exists() ) {
			
			return $existing_license;
			
		} else {
			
			$new_key   = ( isset( $input['key'] ) )   ? trim( $input['key'] )   : '';
			$new_email = ( isset( $input['email'] ) ) ? trim( $input['email'] ) : '';
			
			if ( ! $new_key && ! $new_email ) {
				return false;
			}
			
			$result = $license->activate( array(
				'licence_key' => $new_key,
				'email'       => $new_email,
			) );
			
			$new_license          = array();
			$new_license['key']   = $new_key;
			$new_license['email'] = $new_email;
			
			if ( isset( $result['activated'] ) && 1 == $result['activated'] ) {
				
				add_settings_error( 'simmer_license', 'simmer-activated', __( 'License activated.', Simmer()->domain ), 'updated' );
				
				return $new_license;
				
			}
			
			if ( false == $result ) {
				
				add_settings_error( 'simmer_license', 'simmer-error', __( 'Could not connect to the Simmer API. Please try again later.', Simmer()->domain ), 'error' );
				
				return false;
				
			} else if ( isset( $result['code'] ) ) {
		
				add_settings_error( 'simmer_license', 'simmer-error', $result['error'] . '. ' . $result['additional_info'], 'error' );
				
				return false;
				
			}
			
		}
		
		return $existing_license;
	}
}

new Simmer_Admin_Settings();
