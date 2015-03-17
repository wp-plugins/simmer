<?php
/**
 * Template tags related to ingredients.
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
 * Get the ingredients for a recipe.
 *
 * @since 1.0.0
 * 
 * @param  int        $recipe_id   Optional. A recipe's ID.
 * @return array|bool $ingredients The array of ingredients or false if none set.
 */
function simmer_get_the_ingredients( $recipe_id = null, $filter = 'display' ) {
	
	if ( ! is_numeric( $recipe_id ) ) {
		$recipe_id = get_the_ID();
	}
	
	$ingredients = get_post_meta( $recipe_id, '_recipe_ingredients', true );
	
	if ( ! empty( $ingredients ) ) {
		
		$_ingredients = array();
		
		// Convert each ingredient array to a Simmer_Ingredient instance.
		foreach ( $ingredients as $ingredient ) {
			$_ingredients[] = simmer_get_ingredient( $ingredient, $filter );
		}
		
		$ingredients = $_ingredients;
	}
	
	/**
	 * Allow others to modify the returned array of ingredients.
	 * 
	 * @since 1.0.0
	 * 
	 * @param array $ingredients The returned array of ingredients or empty if none set.
	 * @param int   $recipe_id    The recipe's ID.
	 */
	$ingredients = apply_filters( 'simmer_get_the_ingredients', $ingredients, $recipe_id );
	
	return $ingredients;
}

/**
 * Get the ingredients list heading text.
 *
 * @since 1.0.0
 *
 * @return string $heading The ingredients list heading text.
 */
function simmer_get_ingredients_list_heading() {
	
	$heading = get_option( 'simmer_ingredients_list_heading', __( 'Ingredients', Simmer::SLUG ) );
	
	/**
	 * Allow others to filter the ingredients list heading text.
	 *
	 * @since 1.0.0
	 * 
	 * @param string $heading The ingredients list heading text.
	 */
	$heading = apply_filters( 'simmer_ingredients_list_heading', $heading );
	
	return $heading;
}

/**
 * Get the ingredients list type.
 *
 * @since 1.0.0
 *
 * @return string $type The ingredients list type.
 */
function simmer_get_ingredients_list_type() {
	
	$type = get_option( 'simmer_ingredients_list_type', 'ul' );
	
	/**
	 * Allow others to filter the ingredients list type.
	 *
	 * @since 1.0.0
	 * 
	 * @param string $type The ingredients list type.
	 */
	$type = apply_filters( 'simmer_ingredients_list_type', $type );
	
	return $type;
}

/**
 * Print or return an HTML list of ingredients for the current recipe.
 *
 * @since 1.0.0
 *
 * @param array $args {
 *     The custom arguments. Optional.
 *     
 *     $type bool   $show_heading Whether show the list heading. Default "true".
 *     $type string $heading      The list heading text. Default "Ingredients".
 *     $type string $heading_type The heading tag. Default "h3".
 *     $type string $list_type    The list tag. Default "ul".
 *     $type string $list_class   The class(es) to apply to the list. Default "simmer-ingredients".
 *     $type string $item_type    The list item tag. Default "li".
 *     $type string $item_class   The class(es) to apply to the list items. Default "simmer-ingredient".
 *     $type string $none_message The message when there are no ingredients. Default "This recipe has no ingredients".
 *     $type string $none_class   The class to apply to the "none" message. Default "simmer-info".
 *     $type bool   $echo         Whether to echo or return the generated list. Default "true".
 * }
 * @return string $output The HTML list of ingredients.
 */
function simmer_list_ingredients( $args = array() ) {
	
	$defaults = array(
		'show_heading' => true,
		'heading'	   => simmer_get_ingredients_list_heading(),
		'heading_type' => apply_filters( 'simmer_ingredients_list_heading_type', 'h3' ),
		'list_type'	   => simmer_get_ingredients_list_type(),
		'list_class'   => 'simmer-ingredients',
		'item_type'    => apply_filters( 'simmer_ingredients_list_item_type', 'li' ),
		'item_class'   => 'simmer-ingredient',
		'none_message' => __( 'This recipe has no ingredients', Simmer::SLUG ),
		'none_class'   => 'simmer-message',
		'echo'         => true,
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	/**
	 * Allow other to modify the args.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters( 'simmer_ingredients_list_args', $args );
	
	// Get the array of ingredients.
	$ingredients = simmer_get_the_ingredients();
	
	// Start the output!
	$output = '';
	
	if ( true == $args['show_heading'] ) {
		$output .= '<' . sanitize_html_class( $args['heading_type'] ) . '>';
			$output .= esc_html( $args['heading'] );
		$output .= '</' . sanitize_html_class( $args['heading_type'] ) . '>';
	}
	
	if ( ! empty( $ingredients ) ) {
		
		/**
		 * Fire before listing the ingredients.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_before_ingredients_list' );
		
		/**
		 * Create an array of attributes for the list element.
		 *
		 * Instead of hardcoding these into the tag itself,
		 * we use an associative array so folks can easily add
		 * custom attributes like data-*="" for JavaScript.
		 */
		$list_attributes = array();
		
		if ( ! empty( $args['list_class'] ) ) {
			$list_attributes['class'] = $args['list_class'];
		}
		
		/**
		 * Allow others to filter the list attributes.
		 *
		 * @since 1.0.0
		 * 
		 * @param array $list_attributes {
		 *     The attributes in format $attribute => $value.
		 * }
		 */
		$list_attributes = (array) apply_filters( 'simmer_ingredients_list_attributes', $list_attributes );
		
		// Build the list's opening tag based on the attributes above.
		$output .= '<' . sanitize_html_class( $args['list_type'] );
			
			if ( ! empty( $list_attributes ) ) {
				
				foreach( $list_attributes as $attribute => $value ) {
					$output .= ' ' . sanitize_html_class( $attribute ) . '="' . esc_attr( $value ) . '"';
				}
			}
			
		$output .= '>';
			
			// Loop through the ingredients.
			foreach ( $ingredients as $ingredient ) {
				
				/**
				 * Fire before printing the current ingredient.
				 *
				 * @since 1.0.0
				 * 
				 * @param array $ingredient The current ingredient in the list.
				 */
				do_action( 'simmer_before_ingredients_list_item', $ingredient );
				
				/**
				 * Create an array of attributes for the list element.
				 *
				 * Instead of hardcoding these into the tag itself,
				 * we use an associative array so folks can easily add
				 * custom attributes like data-*="" for JavaScript.
				 */
				$item_attributes = array(
					'itemprop' => 'ingredients',
				);
				
				if ( ! empty( $args['item_class'] ) ) {
					$item_attributes['class'] = $args['item_class'];
				}
				
				/**
				 * Allow others to filter the list item attributes.
				 *
				 * @since 1.0.0
				 * 
				 * @param array $item_attributes {
				 *     The attributes in format $attribute => $value.
				 * }
				 */
				$item_attributes = (array) apply_filters( 'simmer_ingredients_list_item_attributes', $item_attributes, $ingredient );
				
				// Build the list item opening tag based on the attributes above.
				$output .= '<' . sanitize_html_class( $args['item_type'] );
					
					if ( ! empty( $item_attributes ) ) {
						
						foreach( $item_attributes as $attribute => $value ) {
							$output .= ' ' . sanitize_html_class( $attribute ) . '="' . esc_attr( $value ) . '"';
						}
					}
					
				$output .= '>';
					
					if ( $ingredient->amount ) {
						$output .= '<span class="simmer-ingredient-amount">' . esc_html( $ingredient->amount ) . '</span> ';
					}
					
					if ( $ingredient->unit ) {
						$output .= '<span class="simmer-ingredient-unit">' . esc_html( $ingredient->unit ) . '</span> ';
					}
					
					if ( $ingredient->description ) {
						$output .= '<span class="simmer-ingredient-description">' . esc_html( $ingredient->description ) . '</span>';
					}
					
				// Close the list item.
				$output .= '</' . sanitize_html_class( $args['item_type'] ) . '>';
				
				/**
				 * Fire after printing the current ingredient.
				 *
				 * @since 1.0.0
				 * 
				 * @param array $ingredient The current ingredient in the list.
				 */
				do_action( 'simmer_after_ingredients_list_item', $ingredient );
				
			}
			
		// Close the list.
		$output .= '</' . sanitize_html_class( $args['list_type'] ) . '>';
		
		/**
		 * Fire after listing the ingredients.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_after_ingredients_list' );
		
	} else {
		
		// No ingredients to list!
		$output .= '<p class="' . sanitize_html_class( $args['none_class'] ) . '">' . esc_html( $args['none_message'] ) . '</p>';
		
	}
	
	// Echo or return based on the $args.
	if ( true == $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}
