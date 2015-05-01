<?php
/**
 * The main admin class
 *
 * Here we define the class that sets up
 * the admin and all its related functionality.
 *
 * @since 1.0.0
 *
 * @package Simmer\Admin
 */
 
// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The main admin class.
 */
final class Simmer_Admin {

	/** Singleton **/
	
	/**
	 * The only instance of this class.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var object The only instance of this class.
	 */
	protected static $_instance = null;
	
	/**
	 * Get the main instance.
	 *
	 * Insure that only one instance of this class exists in memory at any one time.
	 *
	 * @since 1.0.0
	 *
	 * @return The only instance of this class.
	 */
	public static function get_instance() {
		
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Prevent this class from being loaded more than once.
	 *
	 * @since 1.0.0
	 * @access private
	 * 
	 * @return void
	 */
	public function __construct() {
		
		// Load the necessary supporting files.
		$this->require_files();
		
		// Add the essential action hooks.
		$this->add_actions();
		
		// Add the essential filter hooks.
		$this->add_filters();
	}
	
	/**
	 * Prevent this class from being cloned.
	 *
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function __clone() {
		
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', Simmer()->domain ), Simmer()->version );
	}
	
	/**
	 * Prevent this class from being unserialized.
	 *
	 * @since 1.0.0
	 * 
	 * @return void
	 */
	public function __wakeup() {
		
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', Simmer()->domain ), Simmer()->version );
	}
	
	/** Private Methods **/
	
	/**
	 * Require the necessary files.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function require_files() {
		
		/**
		 * The Recipes admin.
		 */
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-admin-recipes.php' );
		
		/**
		 * The Settings admin.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-admin-settings.php'  );
		
		/**
		 * Supporting functions.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'functions/units.php'       );
		
		/**
		 * The Recipes admin.
		 */
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-admin-bulk-add.php' );
		
		$bulk_add = new Simmer_Admin_Bulk_Add();
		
		/**
		 * The shortcode UI.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-admin-shortcode-ui.php' );
		
		$shortcode_ui = new Simmer_Admin_Shortcode_UI();
		
		/**
		 * Require the plugins list table row customizing class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'settings/class-simmer-plugins-list-table-row.php' );
	}
	
	/**
	 * Call the necessary action hooks.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function add_actions() {
		
		// Enqueue the custom Javascript files.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		// Add the plugin list table row settings link.
		add_action( 'admin_init', array( 'Simmer_Plugins_List_Table_Row', 'get_instance' ) );
		
		// Add a Simmer thanks link to the admin footer.
		add_filter( 'admin_footer_text', array( $this, 'footer_text' ), 20 );
	}
	
	/**
	 * Call the necessary filter hooks.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @return void
	 */
	private function add_filters() {
		
		// Add the published recipe count to the 'At a Glance' dashboard widget.
		add_filter( 'dashboard_glance_items', array( $this, 'add_glance_recipe_count' ) );
	}
	
	/** Public Methods **/
	
	/**
	 * Enqueue the custom scripts & styles.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_scripts( $hook ) {
		
		wp_enqueue_style( 'simmer-admin-styles', plugin_dir_url( __FILE__ ) . 'assets/admin.css', array( 'dashicons' ), Simmer()->version );
		
		// Only enqueue the script when dealing with our main object type (recipe).
		if ( ( 'post.php' == $hook || 'post-new.php' == $hook ) && get_post_type() == simmer_get_object_type() ) {
			
			wp_enqueue_script( 'simmer-admin-scripts', plugin_dir_url( __FILE__ ) . 'assets/admin.js', array( 'jquery' ), Simmer()->version, true );
			
			wp_localize_script( 'simmer-admin-scripts', 'simmer_vars', array(
				'remove_ingredient_min'  => __( 'You must have at least one ingredient!',     Simmer()->domain ),
				'remove_instruction_min' => __( 'You must have at least one instruction!',    Simmer()->domain ),
				'remove_ays'             => __( 'Are you sure you want to remove this item?', Simmer()->domain ),
			) );
			
			wp_enqueue_script( 'simmer-admin-bulk-script', plugin_dir_url( __FILE__ ) . 'assets/bulk-add.js', array( 'jquery' ), Simmer()->version, true );
			
			wp_localize_script( 'simmer-admin-bulk-script', 'simmer_bulk_add_vars', array(
				
				// Ingredients text.
				'ingredients_title'       => __( 'Add Bulk Ingredients', Simmer()->domain ),
				'ingredients_help'        => __( 'Type or paste the list of ingredients below, one ingredient per line.', Simmer()->domain ),
				'ingredients_placeholder' => __( 'e.g. 1 cup flour, sifted', Simmer()->domain ),
				'ingredients_button'      => __( 'Add Ingredients',      Simmer()->domain ),
				
				// Instructions text.
				'instructions_title'       => __( 'Add Bulk Instructions', Simmer()->domain ),
				'instructions_help'        => __( 'Type or paste the list of instructions below, one instruction per line.', Simmer()->domain ),
				'instructions_placeholder' => __( 'e.g. Preheat your oven to 450 degrees.', Simmer()->domain ),
				'instructions_button'      => __( 'Add Instructions',      Simmer()->domain ),
				
				// Misc. text.
				'error_message'       => __( 'Something went wrong. Please try again.', Simmer()->domain ),
				'ajax_url'            => admin_url( 'admin-ajax.php' ),
			) );
		}
	}
	
	/**
	 * Add the published recipe count to the 'At a Glance' dashboard widget.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $elements The current at-a-glance items.
	 * @return array $elements The new at-a-glance items.
	 */
	public function add_glance_recipe_count( $elements ) {
		
		$post_type = simmer_get_object_type();
		
		// Get the number of recipes.
		$num_posts = wp_count_posts( $post_type );
		
		if ( $num_posts && $num_posts->publish ) {
			
			$text = _n( '%s Recipe', '%s Recipes', $num_posts->publish, Simmer()->domain );
			
			$text = sprintf( $text, number_format_i18n( $num_posts->publish ) );
			
			$post_type_object = get_post_type_object( $post_type );
			
			if ( $post_type_object && current_user_can( $post_type_object->cap->edit_posts ) ) {
				$text = sprintf( '<a class="simmer-recipe-count" href="edit.php?post_type=%1$s">%2$s</a>', $post_type, $text );
			} else {
				$text = sprintf( '<span class="simmer-recipe-count">%2$s</span>', $post_type, $text );
			}
			
			$elements[] = $text;
		}
		
		return $elements;
	}
	
	/**
	 * Add a Simmer thanks link to the admin footer.
	 *
	 * @since 1.3.0
	 *
	 * @param  string $text The default admin footer text.
	 * @return string $text The new admin footer text with the Simmer link appended.
	 */
	public function footer_text( $text ) {
		
		$text = '<span id="footer-thankyou">';
			
			$text .= sprintf(
				__( 'Thank you for creating with %sWordPress%s and cooking with %sSimmer%s.', Simmer()->domain ),
				'<a href="http://wordpress.org/">',
				'</a>',
				'<a href="https://simmerwp.com/">',
				'</a>'
			);
			
		$text .= '</span>';
		
		return $text;
	}
}
