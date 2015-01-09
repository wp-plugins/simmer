<?php 
/**
 * Define the [recipe] shortcode.
 *
 * @since 1.0.0
 *
 * @package Simmer\Shortcode
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Build the [recipe] shortcode.
 *
 * This shortcode allows users to embed recipes
 * in their posts & pages.
 *
 * @since 1.0.0
 *
 * @param array $args The available args.
 *        'id' => A recipe ID.
 * @return object The recipe HTML.
 */
function simmer_recipe_shortcode( $args ) {
	global $post;
	
	// Set the default args.
	$defaults = array(
		'id' => 0,
	);
	
	// Parse the user args, if any.
	$args = shortcode_atts( $defaults, $args );
	
	// Setup the $post object for setup_postdata().
	$post = get_post( $args['id'] );
	
	// If no recipe exists with the passed ID, bail.
	if ( is_null( $post ) ) {
		return;
	}
	
	ob_start();
	
	setup_postdata( $post );
	
	/**
	 * Allow others to execute code before including the template file.
	 *
	 * @since 1.0.0
	 */
	do_action( 'simmer_before_recipe_shortcode', $post );
	
	// Include the template file.
	simmer_get_template_part( 'recipe', 'shortcode' );
	
	/**
	 * Allow others to execute code after including the template file.
	 *
	 * @since 1.0.0
	 */
	do_action( 'simmer_after_recipe_shortcode', $post );
	
	// Reset the $post global.
	wp_reset_postdata();
	
	return ob_get_clean();
}
add_shortcode( 'recipe', 'simmer_recipe_shortcode', 99, 1 );
