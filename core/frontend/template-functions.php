<?php
/**
 * Define the front-end template functions
 *
 * @since 1.2.0
 *
 * @package Simmer/Frontend
 */

/**
 * Determine if a recipe's featured image has been set.
 *
 * @since 1.2.0
 *
 * @param  int  $recipe_id          Optional. The ID of the recipe to check. Defaults to the currently looped recipe.
 * @return bool $has_featured_image Whether the recipe's featured image has been set.
 */
function simmer_recipe_has_featured_image( $recipe_id = null ) {

	if ( is_null( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}

	// Check if the featured image has been set.
	$has_featured_image = has_post_thumbnail( $recipe_id );

	/**
	 * Filter the recipe's featured image status.
	 *
	 * @since 1.2.0
	 *
	 * @param int $recipe_id The ID of the recipe to check.
	 */
	$has_featured_image = (bool) apply_filters( 'simmer_recipe_has_featured_image', $has_featured_image, $recipe_id );

	return $has_featured_image;
}
