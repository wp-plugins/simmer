<?php
/**
 * Template tags related to other recipe information.
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
 * Print the current recipe's servings.
 *
 * @since 1.0.0
 * @see simmer_get_the_servings()
 * 
 * @param string $before Optional. To print before the servings string.
 * @param string $after  Optional. To print after the servings string.
 * @return void
 */
function simmer_the_servings( $before = '', $after = '' ) {
	
	if ( $servings = simmer_get_the_servings() ) {
		echo $before . esc_html( $servings ) . $after;
	}
}

/**
 * Get the recipe's servings.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id Optional. A recipe's ID.
 * @return string $servings  The recipe's servings
 */
function simmer_get_the_servings( $recipe_id = null ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$servings = get_post_meta( $recipe_id, '_recipe_servings', true );
	
	/**
	 * Filter the returned servings value.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $servings  The returned servings or '' if none set.
	 * @param int         $recipe_id The recipe's ID.
	 */
	$servings = apply_filters( 'simmer_get_the_servings', $servings, $recipe_id );
	
	return $servings;
}

/**
 * Print the current recipe's yield.
 *
 * @since 1.0.0
 * @see simmer_get_the_yield()
 * 
 * @param string $before Optional. To print before the yield string.
 * @param string $after  Optional. To print after the yield string.
 * @return void
 */
function simmer_the_yield( $before = '', $after = '' ) {
	
	if ( $yield = simmer_get_the_yield() ) {
		echo $before . esc_html( $yield ) . $after;
	}
}

/**
 * Get the recipe's yield.
 *
 * @since 1.0.0
 * 
 * @param  int    $recipe_id Optional. A recipe's ID.
 * @return string $yield     The recipe's yield
 */
function simmer_get_the_yield( $recipe_id = null ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$yield = get_post_meta( $recipe_id, '_recipe_yield', true );
	
	/**
	 * Allow others to modify the returned yield value.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $yield     The returned yield or false if none set.
	 * @param int         $recipe_id The recipe's ID.
	 */
	$yield = apply_filters( 'simmer_get_the_yield', $yield, $recipe_id );
	
	return $yield;
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
	
	echo simmer_get_the_attribution();
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
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$text = simmer_get_attribution_text( $recipe_id );
	$url  = simmer_get_attribution_url(  $recipe_id );
	
	// If no text is set, use the URL.
	if ( ! $text ) {
		
		// If there is no URL AND no text, bail.
		if ( $url ) {
			$text = $url;
		} else {
			return false;
		}
	}
	
	$attribution = $text;
	
	if ( $anchor && $url ) {
		$attribution = '<a class="simmer-recipe-attribution-link" href="' . esc_url( $url ) . '" target="_blank">';
			$attribution .= esc_html( $text );
		$attribution .= '</a>';
	}
	
	/**
	 * Filter the attribution.
	 * 
	 * @since 1.0.0
	 * 
	 * @param string|bool $attribution The attribution.
	 * @param int         $recipe_id   The recipe's ID.
	 */
	$attribution = apply_filters( 'simmer_get_the_attribution', $attribution, $recipe_id );
	
	return $attribution;
}
