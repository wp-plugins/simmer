<?php
/**
 * Define the recipe information functions
 * 
 * @since 1.0.0
 *
 * @package Simmer\Functions
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get a recipe's attribution text.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id A recipe's ID.
 * @return string $text      The recipe's attribution text.
 */
function simmer_get_attribution_text( $recipe_id ) {
	
	$text = get_post_meta( $recipe_id, '_recipe_attribution_text', true );
	
	/**
	 * Filter the returned attribution text.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string $url       The returned attribution text or '' on failure.
	 * @param int    $recipe_id The recipe's ID.
	 */
	$text = apply_filters( 'simmer_get_attribution_text', $text, $recipe_id );
	
	return $text;
}

/**
 * Get a recipe's attribution URL.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id A recipe's ID.
 * @return string $url       The recipe's attribution URL.
 */
function simmer_get_attribution_url( $recipe_id ) {
	
	$url = get_post_meta( $recipe_id, '_recipe_attribution_url', true );
	
	/**
	 * Filter the returned attribution URL.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string $url       The returned attribution URL or '' on failure.
	 * @param int    $recipe_id The recipe's ID.
	 */
	$url = apply_filters( 'simmer_get_attribution_url', $url, $recipe_id );
	
	return $url;
}
