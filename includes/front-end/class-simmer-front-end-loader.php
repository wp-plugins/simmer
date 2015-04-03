<?php
/**
 * Set up the front-end
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Front_End
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Front_End_Loader {
	
	/**
	 * Whether the recipe schema wrapper has been opened.
	 *
	 * @since  1.2.1
	 * @access private
	 *
	 * @var bool $schema_wrap_open
	 */
	private $schema_wrap_open = false;
	
	/**
	 * Get the loader running.
	 * 
	 * @since 1.2.0
	 */
	public function load() {
		
		// Load the necessary files.
		$this->load_files();
		
		// Add the necessary actions.
		$this->add_actions();
		
		// Add the necessary filters.
		$this->add_filters();
	}
	
	/**
	 * Load the necessary files.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function load_files() {
		
		/**
		 * The all-important template loader.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-template-loader.php' );
		
		/**
		 * The HTML classes class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-front-end-classes.php' );
		
		/**
		 * The CSS styles class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-front-end-styles.php' );
		
		/**
		 * The JS scripts class.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'class-simmer-frontend-scripts.php' );
		
		/**
		 * The supporting functions.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'functions.php' );
		
		/**
		 * The supporting template functions.
		 */
		require_once( plugin_dir_path( __FILE__ ) . 'template-functions.php' );
	}
	
	/**
	 * Add the necessary actions.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function add_actions() {
		
		/**
		 * Set up the styles.
		 */
		$styles = new Simmer_Front_End_Styles();
		
		// Check if front-end styles should be enqueued.
		if ( $styles->enable_styles() ) {
			add_action( 'wp_enqueue_scripts', array( $styles, 'enqueue_styles' ) );
			add_action( 'wp_head', array( $styles, 'add_custom_styles' ) );
		}
		
		/**
		 * Set up the scripts.
		 */
		$scripts = new Simmer_Frontend_Scripts();
		
		// Check if front-end scripts should be enqueued.
		if ( $scripts->enable_scripts() ) {
			add_action( 'wp_enqueue_scripts', array( $scripts, 'enqueue_scripts' ) );
		}
		
		// Add the opening schema markup before outputting the recipe.
		add_action( 'loop_start', array( $this, 'open_schema_wrap' ) );
		
		// Add the closing schema markup after outputting the recipe.
		add_action( 'loop_end', array( $this, 'close_schema_wrap' ) );

	}
	
	/**
	 * Add the necessary filters.
	 * 
	 * @since  1.2.0
	 * @access private
	 */
	private function add_filters() {
		
		/**
		 * Setup the HTML classes.
		 */
		$html_classes = new Simmer_Front_End_Classes();
		add_filter( 'body_class', array( $html_classes, 'add_body_classes' ), 20, 1 );
		add_filter( 'post_class', array( $html_classes, 'add_recipe_classes' ), 20, 3 );
		
		// Wrap the title with the proper schema markup.
		add_filter( 'the_title', array( $this, 'add_title_schema' ), 10, 2 );
		
		// Add schema.org property to a single recipe's featured image.
		add_filter( 'wp_get_attachment_image_attributes', array( $this, 'add_featured_image_schema' ), 20, 2 );
		
		// Add the recipe display to the bottom of a singular recipe's content.
		add_filter( 'the_content', array( $this, 'append_recipe' ), 99, 1 );
	}
	
	/**
	 * Add the opening schema markup before outputting the recipe.
	 * 
	 * @since 1.3.0
	 * 
	 * @param object $query The currently looped WP_Query.
	 */
	public function open_schema_wrap( $query ) {
		
		if ( true === $this->schema_wrap_open ) {
			return;
		}
		
		if ( $query->is_singular( simmer_get_object_type() ) && $query->is_main_query() ) {
			
			$this->schema_wrap_open = true;
			
			echo '<span itemscope itemtype="http://schema.org/Recipe">';
		}
	}
	
	/**
	 * Add the closing schema markup after outputting the recipe.
	 * 
	 * @since 1.3.0
	 * 
	 * @param object $query The currently looped WP_Query.
	 */
	public function close_schema_wrap( $query ) {
		
		if ( false === $this->schema_wrap_open ) {
			return;
		}
		
		if ( $query->is_singular( simmer_get_object_type() ) && $query->is_main_query() ) {
			
			$this->schema_wrap_open = false;
			
			echo '</span>';
		}
	}
	
	/**
	 * Wrap the title with the proper schema markup.
	 * 
	 * @since 1.3.0
	 * 
	 * @param  string $title The recipe's title.
	 * @param  int    $id    The recipe's ID.
	 * @return string $title The recipe's title with schema markup added.
	 */
	public function add_title_schema( $title, $id = 0 ) {
		
		$wrapped_title = $title;
		
		if ( $id == get_the_ID() && is_singular( simmer_get_object_type() ) && is_main_query() ) {
			
			$wrapped_title = '<span itemprop="name">';
				$wrapped_title .= $title;
			$wrapped_title .= '</span>';
		}
		
		return $wrapped_title;
	}
	
	/**
	 * Add schema.org property to a single recipe's featured image.
	 *
	 * @since 1.2.1
	 *
	 * @param  array  $attributes The existing image attributes.
	 * @param  object $image      The image's post object.
	 * @return array  $attributes The image attributes, possibly with the schema.org property added.
	 */
	public function add_featured_image_schema( $attributes, $image ) {
		
		if ( $image->ID == get_post_thumbnail_id( get_the_ID() ) && is_singular( simmer_get_object_type() ) && is_main_query() ) {
			
			$attributes['itemprop'] = 'image';
		}
		
		return $attributes;
	}
	
	/**
	 * Add the recipe display to the bottom of a singular recipe's content.
	 * 
	 * @since 1.2.0
	 * 
	 * @param string $content The TinyMCE content.
	 */
	public function append_recipe( $content ) {
		
		if ( ! is_singular( simmer_get_object_type() ) ) {
			return $content;
		}
		
		ob_start();
		
		echo '<div class="simmer-recipe-description" itemprop="description">';
			
			echo $content;
			
		echo '</div><!-- .simmer-recipe-description -->';
		
		do_action( 'simmer_before_recipe', get_the_ID() );
		
		simmer_get_template_part( 'recipe' );
		
		do_action( 'simmer_after_recipe', get_the_ID() );
		
		return ob_get_clean();
	}
}
