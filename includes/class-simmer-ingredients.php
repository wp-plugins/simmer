<?php
/**
 * The main ingredients class
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Ingredients
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Simmer_Ingredients {
	
	/**
	 * Get the available units of measure.
	 *
	 * @since 1.0.0
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
