<?php
/**
 * Define the main ingredients class
 * 
 * @since 1.3.0
 * 
 * @package Simmer/Recipes/Items/Ingredients
 */

/**
 * The class that handles the specialty ingredients funcitonality.
 * 
 * @since 1.3.0
 */
final class Simmer_Recipe_Ingredients {
	
	/**
	 * Get the ingredients list heading text.
	 *
	 * @since 1.3.0
	 *
	 * @return string $heading The ingredients list heading text.
	 */
	public function get_list_heading() {
		
		$heading = get_option( 'simmer_ingredients_list_heading', __( 'Ingredients', Simmer()->domain ) );
		
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
	 * @since 1.3.0
	 *
	 * @return string $type The ingredients list type.
	 */
	public function get_list_type() {
		
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
	 * Get an existing ingredient.
	 *
	 * @since 1.3.0
	 *
	 * @param int          $ingredient_id The ingredient ID.
	 * @return object|bool $ingredient    The ingredient object on success, false on failure.
	 */
	public function get_ingredient( $ingredient_id ) {
		
		$ingredient = new Simmer_Recipe_Ingredient( $ingredient_id );
		
		if ( is_null( $ingredient->id ) ) {
			$ingredient = false;
		}
		
		return $ingredient;
	}
	
	/**
	 * Add a new ingredient.
	 *
	 * @since 1.3.0
	 *
	 * @param  int      $recipe_id   The recipe ID.
	 * @param  string   $description The ingredient description.
	 * @param  float    $amount      Optional. The ingredient amount.
	 * @param  string   $unit        Optional. The ingredient unit.
	 * @param  int      $order       Optional. The ingredient order number.
	 * @return int|bool $result      The new ingredient's ID or false on failure.
	 */
	public function add_ingredient( $recipe_id, $description, $amount = null, $unit = '', $order = 0 ) {
		
		if ( ! absint( $recipe_id ) ) {
			return false;
		}
		
		// Try adding the item to the database.
		$item_id = simmer_add_recipe_item( $recipe_id, 'ingredient', $order );
		
		// If successful, add the metadata.
		if ( $item_id ) {
			
			simmer_add_recipe_item_meta( $item_id, 'description', $description );
			
			$amount = floatval( $amount );
			
			if ( ! empty( $amount ) ) {
				simmer_add_recipe_item_meta( $item_id, 'amount', $amount );
			}
			
			$unit = sanitize_text_field( $unit );
			
			if ( ! empty( $unit ) ) {
				simmer_add_recipe_item_meta( $item_id, 'unit', $unit );
			}
		}
		
		return $item_id;
	}
	
	/**
	 * Update an existing ingredient.
	 *
	 * @since 1.3.0
	 * 
	 * @param int   $ingredient_id The ID for the ingredient to update.
	 * @param array $args {
	 *     The updated ingredient values.
	 *     
	 *     @type int    $recipe_id   The recipe ID.
	 *     @type float  $amount      The ingredient amount.
	 *     @type string $unit        Optional. The ingredient unit.
	 *     @type string $description Optional. The ingredient description.
	 *     @type int    $order       Optional. The ingredient order number.
	 * }
	 * @return int|bool $result The ingredient ID or false on failure.
	 */
	public function update_ingredient( $ingredient_id, $args ) {
		
		$exists = simmer_get_recipe_ingredient( $ingredient_id );
		
		if ( ! $exists ) {
			return false;
		}
		
		$item_args = array();
		
		if ( isset( $args['recipe_id'] ) ) {
			
			$recipe_id = absint( $args['recipe_id'] );
			
			if ( $recipe_id ) {
				$item_args['recipe_id'] = $recipe_id;
			}
		}
		
		if ( isset( $args['order'] ) ) {
			
			if ( is_numeric( $args['order'] ) ) {
				$item_args['recipe_item_order'] = absint( $args['order'] );
			}
		}
		
		if ( ! empty( $item_args ) ) {
			simmer_update_recipe_item( $ingredient_id, $item_args );
		}
		
		if ( isset( $args['amount'] ) ) {
			
			$amount = floatval( $args['amount'] );
			
			if ( $amount ) {
				simmer_update_recipe_item_meta( $ingredient_id, 'amount', $amount );
			} else {
				simmer_delete_recipe_item_meta( $ingredient_id, 'amount' );
			}
		}
		
		if ( isset( $args['unit'] ) ) {
			
			$unit = sanitize_text_field( $args['unit'] );
			
			if ( ! empty( $unit ) ) {
				simmer_update_recipe_item_meta( $ingredient_id, 'unit', $unit );
			} else {
				simmer_delete_recipe_item_meta( $ingredient_id, 'unit' );
			}
		}
		
		if ( isset( $args['description'] ) ) {
			
			if ( ! empty( $args['description'] ) ) {
				simmer_update_recipe_item_meta( $ingredient_id, 'description', $args['description'] );
			} else {
				simmer_delete_recipe_item_meta( $ingredient_id, 'description' );
			}
		}
		
		return $ingredient_id;
	}
	
	/**
	 * Delete an existing ingredient.
	 *
	 * @since 1.3.0
	 *
	 * @param  int  $ingredient_id The ID for the ingredient you want to delete.
	 * @return bool $result        Whether the ingredient was deleted.
	 */
	public function delete_ingredient( $ingredient_id ) {
		
		$result = simmer_delete_recipe_item( $ingredient_id );
		
		if ( $result ) {
			
			simmer_delete_recipe_item_meta( $ingredient_id, 'amount' );
			simmer_delete_recipe_item_meta( $ingredient_id, 'unit' );
			simmer_delete_recipe_item_meta( $ingredient_id, 'description' );
		}
		
		return $result;
	}
	
	/**
	 * Get the available units of measure.
	 *
	 * @since 1.3.0
	 *
	 * @return array $units The filtered units.
	 */
	public static function get_units() {
		
		$units = array(
			'volume' => array(
				'tsp' => array(
					'single' => 'teaspoon',
					'plural' => 'teaspoons',
					'abbr'   => 'tsp.',
				),
				'tbsp' => array(
					'single' => 'tablespoon',
					'plural' => 'tablespoons',
					'abbr'   => 'tbsp.',
				),
				'floz' => array(
					'single' => 'fluid ounce',
					'plural' => 'fluid ounces',
					'abbr'   => 'fl oz',
				),
				'cup' => array(
					'single' => 'cup',
					'plural' => 'cups',
					'abbr'   => 'c',
				),
				'pint' => array(
					'single' => 'pint',
					'plural' => 'pints',
					'abbr'   => 'pt',
				),
				'quart' => array(
					'single' => 'quart',
					'plural' => 'quarts',
					'abbr'   => 'qt',
				),
				'gal' => array(
					'single' => 'gallon',
					'plural' => 'gallons',
					'abbr'   => 'gal',
				),
				'ml' => array(
					'single' => 'milliliter',
					'plural' => 'milliliters',
					'abbr'   => 'mL',
				),
				'liter' => array(
					'single' => 'liter',
					'plural' => 'liters',
					'abbr'   => 'L',
				),
			),
			'weight' => array(
				'lb' => array(
					'single' => 'pound',
					'plural' => 'pounds',
					'abbr'   => 'lb',
				),
				'oz' => array(
					'single' => 'ounce',
					'plural' => 'ounces',
					'abbr'   => 'oz',
				),
				'mg' => array(
					'single' => 'milligram',
					'plural' => 'milligrams',
					'abbr'   => 'mg',
				),
				'gram' => array(
					'single' => 'gram',
					'plural' => 'grams',
					'abbr'   => 'g',
				),
				'kg' => array(
					'single' => 'killogram',
					'plural' => 'killograms',
					'abbr'   => 'kg',
				),
			),
			'misc' => array(
				'pinch' => array(
					'single' => 'pinch',
					'plural' => 'pinches',
					'abbr'   => false,
				),
				'dash' => array(
					'single' => 'dash',
					'plural' => 'dashes',
					'abbr'   => false,
				),
				'package' => array(
					'single' => 'package',
					'plural' => 'packages',
					'abbr'   => 'pkg',
				),
			),
		);
		
		/**
		 * Filter the available units.
		 *
		 * @since 1.0.0
		 * 
		 * @param array $units The available units of measure.
		 */
		$units = apply_filters( 'simmer_get_units', $units );
		
		return $units;
	}
}
