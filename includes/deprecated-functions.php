<?php
/**
 * Define the deprecated functions
 * 
 * @since 1.1.0
 * 
 * @package Simmer/Deprecated
 */

/**
 * Mark a function as deprecated and trigger an error.
 *
 * The current behavior is to trigger a user error if WP_DEBUG is true.
 *
 * This function is to be used in every function that is deprecated.
 *
 * Adapted from Easy Digital Downloads (https://github.com/easydigitaldownloads/Easy-Digital-Downloads)
 *
 * @param string  $function    The function that was called
 * @param string  $version     The version of Simmer that deprecated the function
 * @param string  $replacement Optional. The function that should have been called
 */
function _simmer_deprecated_function( $function, $version, $replacement = null ) {
	
	$show_errors = current_user_can( 'manage_options' );
	
	// Allow plugin to filter the output error trigger
	if ( WP_DEBUG && apply_filters( 'simmer_deprecated_function_trigger_error', $show_errors ) ) {
		
		if ( ! is_null( $replacement ) ) {
			
			trigger_error(
				sprintf( __( '%1$s is <strong>deprecated</strong> since Simmer version %2$s! Use %3$s instead.', Simmer::SLUG ),
					$function,
					$version,
					$replacement
				)
			);
			
		} else {
			
			trigger_error(
				sprintf( __( '%1$s is <strong>deprecated</strong> since Simmer version %2$s with no alternative available.', Simmer::SLUG ),
					$function,
					$version
				)
			);
			
		}
	}
}

/**
 * Print the current recipe's attribution.
 *
 * @since 1.0.0
 * @see simmer_get_the_attribution()
 * 
 * @return void
 */
function simmer_the_attribution() {
	
	_simmer_deprecated_function( __FUNCTION__, '1.1.0', 'simmer_the_source' );
	
	echo simmer_get_the_source();
}

/**
 * Get a recipe's attribution.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id   Optional. A recipe's ID. Defaults to current.
 * @param  bool   $anchor      Optional. Whether to wrap the attribution in an anchor.
 * @return string $attribution The recipe's attribution.
 */
function simmer_get_the_attribution( $recipe_id = null, $anchor = true ) {
	
	_simmer_deprecated_function( __FUNCTION__, '1.1.0', 'simmer_get_the_source' );
	
	return simmer_get_the_source( $recipe_id, $anchor );
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
	
	_simmer_deprecated_function( __FUNCTION__, '1.1.0', 'simmer_get_source_text' );
	
	$text = get_post_meta( $recipe_id, '_recipe_attribution_text', true );
	
	// For forward compat, check for the new "source" key.
	if ( ! $text ) {
		$text = get_post_meta( $recipe_id, '_recipe_source_text', true );
	}
	
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
	
	_simmer_deprecated_function( __FUNCTION__, '1.1.0', 'simmer_get_source_url' );
	
	$url = get_post_meta( $recipe_id, '_recipe_attribution_url', true );
	
	// For forward compat, check for the new "source" key.
	if ( ! $url ) {
		$url = get_post_meta( $recipe_id, '_recipe_source_url', true );
	}
	
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

/**
 * Determine whether the default front-end styles should be loaded.
 * 
 * @since 1.0.0
 * 
 * @return bool $enqueue_styles Whether the styles should be loaded.
 */
function simmer_enqueue_styles() {
	
	_simmer_deprecated_function( __FUNCTION__, '1.2.0', 'Simmer_Front_End_Styles::enable_styles' );
	
	$enqueue_styles = get_option( 'simmer_enqueue_styles', true );
	
	/**
	 * Filter whether the styles should be loaded.
	 * 
	 * @since 1.0.0
	 * 
	 * @param bool $enqueue_styles Whether the styles are set to load.
	 */
	$enqueue_styles = apply_filters( 'simmer_enqueue_styles', $enqueue_styles );
	
	return (bool) $enqueue_styles;
}
