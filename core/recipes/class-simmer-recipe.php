<?php
/**
 * Define the main recipe class
 *
 * @since 1.3.0
 *
 * @package Simmer/Recipes
 */

/**
 * The single recipe object.
 *
 * @since 1.3.0
 */
final class Simmer_Recipe {
	
	/**
	 * The recipe ID.
	 *
	 * @since 1.3.0
	 *
	 * @var int $id
	 */
	public $id = 0;
	
	/**
	 * The standard WordPress post object.
	 *
	 * @since 1.3.0
	 *
	 * @var object $post
	 */
	public $post = null;
	
	/**
	 * Construct the recipe.
	 * 
	 * @since 1.3.0
	 */
	public function __construct( $recipe ) {
		
		if ( is_numeric( $recipe ) ) {
			$this->id   = absint( $recipe );
			$this->post = get_post( $recipe );
		} elseif ( $recipe instanceof Simmer_Recipe ) {
			$this->id   = absint( $recipe->id );
			$this->post = $recipe->post;
		} elseif ( isset( $recipe->ID ) ) {
			$this->id   = absint( $recipe->ID );
			$this->post = $recipe;
		}
	}
	
	/**
	 * Get the items that belong to the recipe.
	 *
	 * @since 1.3.0
	 *
	 * @param  string $type  Optional. The type of items to get. If blank, all items
	 *                       will be returned. Default: all items.
	 * @return array  $items The attached items.
	 */
	public function get_items( $type = '' ) {
		
		$args = array();
		
		if ( $type ) {
			$args['type'] = esc_attr( $type );
		}
		
		$items_api = new Simmer_Recipe_Items;
		
		$items = (array) $items_api->get_items( $this->id, $args );
		
		/**
		 * Filter a recipe's retrieved items.
		 *
		 * @since 1.3.0
		 *
		 * @param array $items     The retrieved items.
		 * @param int   $recipe_id The recipe ID.
		 */
		$items = apply_filters( 'simmer_get_recipe_items', $items, $this->id );
		
		return $items;
	}
	
	/**
	 * Get the ingredients.
	 *
	 * @since 1.3.0
	 *
	 * @return array $ingredients An array of the recipe's ingredients. An empty array is returned when there
	 *                            are no ingredients for the recipe.
	 */
	public function get_ingredients() {
		
		$items = $this->get_items( 'ingredient' );
		
		$ingredients = array();
		
		foreach ( $items as $item ) {
			
			$ingredients[] = new Simmer_Recipe_Ingredient( $item );
		}
		
		/**
		 * Filter a recipe's retrieved ingredients.
		 *
		 * @since 1.3.0
		 *
		 * @param array $ingredients The retrieved ingredients.
		 * @param int   $recipe_id   The recipe ID.
		 */
		$ingredients = apply_filters( 'simmer_get_recipe_ingredients', $ingredients, $this->id );
		
		return $ingredients;
	}
	
	/**
	 * Get the instructions.
	 *
	 * @since 1.3.0
	 *
	 * @return array $instructions An array of the recipe's instructions. An empty array is returned when there
	 *                             are no instructions for the recipe.
	 */
	public function get_instructions() {
		
		$items = $this->get_items( 'instruction' );
		
		$instructions = array();
		
		foreach ( $items as $item ) {
			
			$instructions[] = new Simmer_Recipe_Instruction( $item );
		}
		
		/**
		 * Filter a recipe's retrieved instructions.
		 *
		 * @since 1.3.0
		 *
		 * @param array $instructions The retrieved instructions.
		 * @param int   $recipe_id    The recipe ID.
		 */
		$instructions = apply_filters( 'simmer_get_recipe_instructions', $instructions, $this->id );
		
		return $instructions;
	}
	
	/**
	 * Get the prep time.
	 *
	 * @since 1.3.0
	 *
	 * @param  string      $format    Optional. The duration format to return. Specify 'machine'
	 *                                for microdata-friendly format. Default: 'human'.
	 * @return string|bool $prep_time The formatted prep time or false on failure.
	 */
	public function get_prep_time( $format = 'human' ) {
		
		$durations_api = new Simmer_Recipe_Durations;
		
		$prep_time = $durations_api->get_duration( 'prep', $this->id );
		
		if ( $prep_time ) {
			
			if ( 'machine' == $format ) {
				$prep_time = $durations_api->format_machine_duration( $prep_time );
			} else {
				$prep_time = $durations_api->format_human_duration( $prep_time );
			}
		}
		
		/**
		 * Filter the prep time.
		 * 
		 * @since 1.3.0
		 * 
		 * @param string|bool $prep_time The returned time string or false if none set.
		 * @param int         $recipe_id The recipe ID.
		 */
		$prep_time = apply_filters( 'simmer_get_recipe_prep_time', $prep_time, $this->id );
		
		return $prep_time;
	}
	
	/**
	 * Get the cook time.
	 *
	 * @since 1.3.0
	 *
	 * @param  string      $format    Optional. The duration format to return. Specify 'machine'
	 *                                for microdata-friendly format. Default: 'human'.
	 * @return string|bool $cook_time The formatted cook time or false on failure.
	 */
	public function get_cook_time( $format = 'human' ) {
		
		$durations_api = new Simmer_Recipe_Durations;
		
		$cook_time = $durations_api->get_duration( 'cook', $this->id );
		
		if ( $cook_time ) {
			
			if ( 'machine' == $format ) {
				$cook_time = $durations_api->format_machine_duration( $cook_time );
			} else {
				$cook_time = $durations_api->format_human_duration( $cook_time );
			}
		}
		
		/**
		 * Filter the cook time.
		 * 
		 * @since 1.3.0
		 * 
		 * @param string|bool $cook_time The returned time string or false if none set.
		 * @param int         $recipe_id The recipe ID.
		 */
		$cook_time = apply_filters( 'simmer_get_recipe_cook_time', $cook_time, $this->id );
		
		return $cook_time;
	}
	
	/**
	 * Get the total time.
	 *
	 * @since 1.3.0
	 *
	 * @param  string      $format     Optional. The duration format to return. Specify 'machine'
	 *                                 for microdata-friendly format. Default: 'human'.
	 * @return string|bool $total_time The formatted total time or false on failure.
	 */
	public function get_total_time( $format = 'human' ) {
		
		$durations_api = new Simmer_Recipe_Durations;
		
		$total_time = $durations_api->get_duration( 'total', $this->id );
		
		if ( $total_time ) {
			
			if ( 'machine' == $format ) {
				$total_time = $durations_api->format_machine_duration( $total_time );
			} else {
				$total_time = $durations_api->format_human_duration( $total_time );
			}
		}
		
		/**
		 * Filter the total time.
		 * 
		 * @since 1.3.0
		 * 
		 * @param string|bool $total_time The returned time string or false if none set.
		 * @param int         $recipe_id  The recipe ID.
		 */
		$total_time = apply_filters( 'simmer_get_recipe_total_time', $total_time, $this->id );
		
		return $total_time;
	}
}
