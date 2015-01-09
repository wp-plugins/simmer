<?php
/**
 * Supporting functions for ingredients.
 *
 * @since 1.0.0
 *
 * @package Simmer\Functions
 */

// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get a specific ingredient.
 * 
 * @since 1.0.0
 * 
 * @param  array        $ingredient The ingredient array from post meta.
 * @return object|false $ingredient An instance of Simmer_Ingredient or false on failure.
 */
function simmer_get_ingredient( $ingredient, $filter = 'display' ) {
	
	// Check if the input is already an instance of Simmer_Ingredient.
	if ( is_a( $ingredient, 'Simmer_Ingredient' ) ) {
		
		return $ingredient;
	
	// Otherwise, if it's not an array, then bail.
	} else if ( ! is_array( $ingredient ) ) {
		return false;
	}
	
	$ingredient = new Simmer_Ingredient( $ingredient, $filter );
	
	return $ingredient;
}
