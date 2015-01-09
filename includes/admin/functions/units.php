<?php
/**
 * Supporting units admin functions
 *
 * @package Simmer\Admin_Functions
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Print or return a <select> field of all avialable units of measure.
 *
 * @since 1.0.0
 *
 * @param array $args The custom arguments.
 * @return string $output The generated <select> field.
 */
function simmer_units_select_field( $args = '', $count = 1 ) {
	
	// Get the available measurement units.
	$units = Simmer_Ingredients::get_units();
	
	// If there are none, then stop generating the <select> field.
	if ( empty( $units ) ) {
		return false;
	}
	
	$defaults = array(
		'name'      => 'simmer-unit',
		'selected'  => '',
		'id'        => '',
		'class'     => 'simmer-units-dropdown',
		'tab_index' => 0,
		'echo'      => true,
	);
	
	$args = wp_parse_args( $args, $defaults );
	
	/**
	 * Allow others to filter the args.
	 *
	 * @since 1.0.0
	 */
	$args = apply_filters( 'simmer_units_select_field_args', $args );
	
	// Start building an array of <select> field attributes.
	$attributes = array();
	
	// If an id is set, add it to the attributes array.
	if ( ! empty( $args['id'] ) ) {
		$attributes['id'] = $args['id'];
	}
	
	// If a class is set, add it to the attributes array.
	if ( ! empty( $args['class'] ) ) {
		$attributes['class'] = $args['class'];
	}
	
	// If a name is set, add it to the attributes array.
	if ( ! empty( $args['name'] ) ) {
		$attributes['name'] = $args['name'];
	}
	
	// If a tab index is set, create the attribute.
	if ( (int) $args['tab_index'] > 0 ) {
		$attributes['tabindex'] = (int) $args['tab_index'];
	}
	
	/**
	 * Allow others to modify the array of attributes.
	 *
	 * @since 1.0.0
	 */
	$attributes = apply_filters( 'simmer_units_select_field_attributes', $attributes );
	
	// If no attributes are defined above, then we have nothing more to discuss.
	if ( empty( $attributes ) || ! is_array( $attributes ) ) {
		return false;
	}
	
	// Start building the <select> field.
	$output = '<select';
		
		foreach( $attributes as $attribute => $value ) {
			$output .= ' ' . esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
		}
		
	$output .= '>';
		
		$output .= '<option value="" ' . selected( '', $args['selected'], false ) . '></option>';
		
		foreach( $units as $unit_type => $units ) {
			
			$output .= '<optgroup label="' . esc_html( ucfirst( $unit_type ) ) . '">';
				
				foreach ( $units as $unit => $labels ) {
					
					$output .= '<option value="' . esc_attr( $unit ) . '" ' . selected( $unit, $args['selected'], false ) . '>';
						$output .= esc_html( Simmer_Ingredient::get_unit_label( $labels, $count ) );
					$output .= '</option>';
					
				}
			
			$output .= '</optgroup>';
		}
		
	$output .= '</select>';
	
	// Echo or return the resulting select field.
	if ( (bool) $args['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}
