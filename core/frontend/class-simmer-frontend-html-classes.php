<?php
/**
 * Define the front-end HTML classes class
 *
 * @since 1.3.0
 *
 * @package Simmer/Frontend
 */

/**
 * Add custom classes to the HTML body & single recipes.
 *
 * @since 1.3.0
 */
final class Simmer_Frontend_HTML_Classes {

	/**
	 * Add special Simmer classes to <body>.
	 *
	 * @since 1.2.0
	 * @see body_class()
	 *
	 * @param  array $classes The existing body classes as generated by WordPress.
	 * @return array $classes The newly generated body classes.
	 */
	public function add_body_classes( $classes ) {

		$object_type = simmer_get_object_type();

		if ( is_singular( $object_type ) || is_post_type_archive( $object_type ) || is_tax( simmer_get_category_taxonomy() ) ) {
			$classes[] = 'simmer';
		}

		/**
		 * Filter the Simmer body classes.
		 *
		 * @since 1.2.0
		 *
		 * @param array  $classes   The generated body classes.
		 */
		$classes = apply_filters( 'simmer_body_classes', $classes );

		return $classes;
	}

	/**
	 * Add special Simmer classes for recipes.
	 *
	 * @since 1.2.0
	 * @see post_class()
	 *
	 * @param  array        $classes   The existing classes as generated by WordPress.
	 * @param  string|array $class     Optional. Any custom classes passed by the post_class() function.
	 * @param  int|bool     $recipe_id Optional. The current recipe ID.
	 * @return array        $classes   The newly generated recipe classes.
	 */
	public function add_recipe_classes( $classes, $class = '', $recipe_id = false ) {

		if ( simmer_get_object_type() !== get_post_type( $recipe_id ) || ! $recipe_id ) {
			return $classes;
		}

		$classes[] = 'simmer-recipe';

		// Check for ingredients and add the appropriate classes.
		$ingredients = simmer_get_the_ingredients();

		if ( ! empty( $ingredients ) ) {

			$classes[] = 'simmer-has-ingredients';
			$classes[] = 'simmer-ingredients-' . zeroise( count( $ingredients ), 2 );

		} else {
			$classes[] = 'simmer-no-ingredients';
		}

		// Check for instructions and add the appropriate classes.
		$instructions = simmer_get_the_instructions();

		if ( ! empty( $instructions ) ) {

			$classes[] = 'simmer-has-instructions';
			$classes[] = 'simmer-instructions-' . zeroise( count( $instructions ), 2 );

		} else {
			$classes[] = 'simmer-no-instructions';
		}

		/**
		 * Filter the recipe classes.
		 *
		 * @since 1.2.0
		 *
		 * @param array  $classes   The generated recipe classes.
		 * @param string $class     Optional. Additional classes to to add, passed by the post_class function.
		 * @param int    $recipe_id Optional. The current recipe's ID.
		 */
		$classes = apply_filters( 'simmer_recipe_classes', $classes, $class, $recipe_id );

		return $classes;
	}
}
