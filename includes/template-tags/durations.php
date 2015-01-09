<?php
/**
 * Template tags related to durations like prep or cooking times.
 *
 * @since 1.0.0
 *
 * @package Simmer\Template_Tags
 */

// If this file is called directly, bail.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Print the prep time of the current recipe in human-readable format.
 *
 * @since 1.0.0
 * @see simmer_get_the_prep_time()
 * 
 * @return void
 */
function simmer_the_prep_time() {
	
	echo esc_html( simmer_get_the_prep_time() );
}

/**
 * Get the prep time for a recipe.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id Optional. A recipe's ID.
 * @return string $time The recipe prep time, in human-readable format.
 */
function simmer_get_the_prep_time( $recipe_id = null ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$time = simmer_get_the_time( 'prep', $recipe_id );
	
	if ( $time ) {
		$time = simmer_format_human_duration( $time );
	}
	
	/**
	 * Allow others to modify the returned time string.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $time      The returned time string or false if none set.
	 * @param int         $recipe_id The recipe's ID.
	 */
	$time = apply_filters( 'simmer_get_the_prep_time', $time, $recipe_id );
	
	return $time;
}

/**
 * Print the total cook of the current recipe in human-readable format.
 *
 * @since 1.0.0
 * @see simmer_get_the_cook_time()
 * 
 * @return void
 */
function simmer_the_cook_time() {
	
	echo esc_html( simmer_get_the_cook_time() );
}

/**
 * Get the cook time for a recipe.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id Optional. A recipe's ID.
 * @return string $time The recipe cook time, in human-readable format.
 */
function simmer_get_the_cook_time( $recipe_id = null ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$time = simmer_get_the_time( 'cook', $recipe_id );
	
	if ( $time ) {
		$time = simmer_format_human_duration( $time );
	}
	
	/**
	 * Allow others to modify the returned time string.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $time      The returned time string or false if none set.
	 * @param int         $recipe_id The recipe's ID.
	 */
	$time = apply_filters( 'simmer_get_the_cook_time', $time, $recipe_id );
	
	return $time;
}

/**
 * Print the total time of the current recipe in human-readable format.
 *
 * @since 1.0.0
 * @see simmer_get_the_total_time()
 * 
 * @return void
 */
function simmer_the_total_time() {
	
	echo esc_html( simmer_get_the_total_time() );
}

/**
 * Get the total time for a recipe.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id Optional. A recipe's ID.
 * @return string $time The recipe total time, in human-readable format.
 */
function simmer_get_the_total_time( $recipe_id = null ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$time = simmer_get_the_time( 'total', $recipe_id );
	
	if ( $time ) {
		$time = simmer_format_human_duration( $time );
	}
	
	/**
	 * Allow others to modify the returned time string.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $time      The returned time string or false if none set.
	 * @param int         $recipe_id The recipe's ID.
	 */
	$time = apply_filters( 'simmer_get_the_total_time', $time, $recipe_id );
	
	return $time;
}

/**
 * Return the given time of a given recipe.
 *
 * @since 1.0.0
 * 
 * @param  string $type      The type of time, prep|cook|total.
 * @param  int    $recipe_id The recipe's ID.
 * @return int    $time      The given recipe time, in minutes.
 */
function simmer_get_the_time( $type, $recipe_id ) {
	
	$time = get_post_meta( $recipe_id, "_recipe_{$type}_time", true );
	
	return $time;
}
