<?php
/**
 * Define the main class
 *
 * @since 1.0.0
 *
 * @package Simmer
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The main class.
 *
 * @since 1.0.0
 */
final class Simmer {
	
	/**
	 * The plugin version.
	 *
	 * @since 1.0.0
	 * 
	 * @var string VERSION The plugin version.
	 */
	const VERSION = '1.2.2';
	
	/**
	 * The plugin slug.
	 *
	 * @since 1.0.0
	 * 
	 * @var string SLUG The plugin slug.
	 */
	const SLUG = 'simmer';
	
	/** Singleton **/
	
	/**
	 * The only instance of this class.
	 *
	 * @since  1.0.0
	 * @access protected
	 * 
	 * @var object $_instance The only instance of this class.
	 */
	protected static $_instance = null;
	
	/**
	 * Get the only instance of this class.
	 *
	 * @since 1.0.0
	 *
	 * @return object $_instance The only instance of this class.
	 */
	public static function get_instance() {
		
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Construct the class.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {
		
		// Load the necessary supporting files.
		$this->require_files();
		
		// Add the essential action hooks.
		$this->add_actions();
		
		/**
		 * Fire after Simmer has been loaded.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_loaded' );
	}
	
	/**
	 * Prevent this class from being cloned.
	 *
	 * @since 1.0.0
	 */
	public function __clone() {
		
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', self::SLUG ), self::VERSION );
	}
	
	/**
	 * Prevent this class from being unserialized.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup() {
		
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', self::SLUG ), self::VERSION );
	}
	
	/** Private Methods **/
	
	/**
	 * Load the necessary supporting files.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function require_files() {
		
		/**
		 * Supporting functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'functions/general.php'     );
		require( plugin_dir_path( __FILE__ ) . 'functions/durations.php'   );
		require( plugin_dir_path( __FILE__ ) . 'functions/ingredients.php' );
		require( plugin_dir_path( __FILE__ ) . 'functions/information.php' );
		
		/**
		 * Template tag functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'template-tags/durations.php'    );
		require( plugin_dir_path( __FILE__ ) . 'template-tags/information.php'  );
		require( plugin_dir_path( __FILE__ ) . 'template-tags/ingredients.php'  );
		require( plugin_dir_path( __FILE__ ) . 'template-tags/instructions.php' );
		
		/**
		 * The single ingredient class.
		 */
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-ingredients.php'  );
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-ingredient.php'  );
		
		/**
		 * The shortcode functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'class-simmer-recipe-shortcode.php' );
		
		/**
		 * The deprecated functions.
		 */
		require( plugin_dir_path( __FILE__ ) . 'deprecated-functions.php' );
		
		/**
		 * The front-end loader.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'front-end/class-simmer-front-end-loader.php' );
	}
	
	/**
	 * Add the essential action hooks.
	 *
	 * @since  1.0.0
	 * @access private
	 */
	private function add_actions() {
		
		// Load the text domain for i18n.
		add_action( 'init', array( $this, 'load_textdomain' ) );
		
		// Register the 'recipe' object type.
		add_action( 'init', array( $this, 'register_object_type' ) );
		
		// Register the category taxonomy.
		add_action( 'init', array( $this, 'register_category_taxonomy' ) );
		
		// Load the front-end functionality.
		$front_end = new Simmer_Front_End_Loader();
		add_action( 'wp', array( $front_end, 'load' ) );
	}
	
	/** Public Methods **/
	
	/**
	 * Load the text domain.
	 *
	 * Based on the bbPress implementation.
	 *
	 * @since 1.0.0
	 * 
	 * @return The textdomain or false on failure.
	 */
	public function load_textdomain() {
		
		$locale = get_locale();
		$locale = apply_filters( 'plugin_locale',  $locale, self::SLUG );
		
		$mofile        = sprintf( self::SLUG . '-%s.mo', $locale );
		$mofile_local  = plugin_dir_path( dirname( __FILE__ ) ) . 'languages/' . $mofile;
		$mofile_global = WP_LANG_DIR . '/' . self::SLUG . '/' . $mofile;
		
		if ( file_exists( $mofile_local ) ) {
			return load_textdomain( self::SLUG, $mofile_local );
		}
		
		if ( file_exists( $mofile_global ) ) {
			return load_textdomain( self::SLUG, $mofile_global );
		}
		
		load_plugin_textdomain( self::SLUG );
		
		return false;
	}
	
	/**
	 * Register the 'recipe' object type.
	 *
	 * @since 1.0.0
	 */
	public function register_object_type() {
		
		// The arguments that define the object type's labels and functionality.
		$args = array(
			'labels'  => array(
				'name'               => __( 'Recipes',                   self::SLUG ),
				'singular_name'      => __( 'Recipe',                    self::SLUG ),
				'all_items'          => __( 'All Recipes',               self::SLUG ),
				'add_new_item'       => __( 'Add New Recipe',            self::SLUG ),
				'edit_item'          => __( 'Edit Recipe',               self::SLUG ),
				'new_item'           => __( 'New Recipe',                self::SLUG ),
				'view_item'          => __( 'View Recipe',               self::SLUG ),
				'search_items'       => __( 'Search Recipes',            self::SLUG ),
				'not_found'          => __( 'No recipes found',          self::SLUG ),
				'not_found_in_trash' => __( 'No recipes found in Trash', self::SLUG ),
			),
			'public'  => true,
			'supports' => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'comments',
				'author',
			),
			'taxonomies' => array(
				simmer_get_category_taxonomy(),
			),
			'has_archive' => simmer_get_archive_base(),
			'rewrite' => array(
				'slug' => trailingslashit( simmer_get_archive_base() ) . get_option( 'simmer_recipe_base', simmer_get_object_type() ),
				'with_front' => false,
			),
		);
		
		/**
		 * Filter the recipe object type arguments.
		 *
		 * @since 1.0.0
		 * @see register_post_type() for the available args.
		 * 
		 * @param array $args {
		 * 		The arguments that define the object type's
		 * 		labels and functionality.
		 * }
		 */
		$args = apply_filters( 'simmer_register_recipe_args', $args );
		
		// Finally register the object type.
		register_post_type( simmer_get_object_type(), $args );
	}
	
	/**
	 * Register the category taxonomy.
	 *
	 * @since 1.0.0
	 */
	public function register_category_taxonomy() {
		
		$args = array(
			'show_tagcloud'     => false,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite' => array(
				'slug'       => trailingslashit( simmer_get_archive_base() ) . get_option( 'simmer_category_base', 'category' ),
				'with_front' => false,
			),
		);
		
		/**
		 * Filter the taxonomy args.
		 *
		 * @since 1.0.0
		 * @see register_taxonomy() for the available args.
		 * 
		 * @param array $args {
		 * 		The arguments that define the taxonomy's
		 * 		labels and functionality.
		 * }
		 */
		$args = apply_filters( 'simmer_register_category_args', $args );
		
		// Finally register the taxonomy.
		register_taxonomy(
			simmer_get_category_taxonomy(),
			simmer_get_object_type(),
			$args
		);
		
		/*
		 * Better safe than sorry.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy#Usage
		 */
		register_taxonomy_for_object_type(
			simmer_get_category_taxonomy(),
			simmer_get_object_type()
		);
	}
}
