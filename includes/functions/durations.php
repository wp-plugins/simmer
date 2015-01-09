<?php
/**
 * Functions related to durations like prep or cooking times.
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
 * Format a given duration to a human-readable format.
 * 
 * @since 1.0.0
 * 
 * @param int $time A duration, in minutes.
 * @return string|bool $duration The human-readable duration or false on failure.
 */
function simmer_format_human_duration( $time ) {
	
	if ( ! is_numeric( $time ) ) {
		return false;
	}
	
	$hours   = floor( $time / 60 );
	$minutes = ( $time % 60 );
	
	if ( ! $hours && ! $minutes ) {
		return false;
	}
	
	$duration = '';
	
	if ( $hours ) {
		$duration .= $hours . 'h';
	}
	
	if ( $hours && $minutes ) {
		$duration .= ' ';
	}
	
	if ( $minutes ) {
		$duration .= $minutes . 'm';
	}
	
	return $duration;
}

/**
 * Format a given duration to a machine-readable format.
 * 
 * @since 1.0.0
 * 
 * @param int $time A duration, in minutes.
 * @return string|bool $duration The machine-readable duration or false on failure.
 */
function simmer_format_machine_duration( $time ) {
	
	if ( ! is_numeric( $time ) ) {
		return false;
	}
	
	$hours   = floor( $time / 60 );
	$minutes = ( $time % 60 );
	
	if ( $hours || $minutes ) {
		$duration = 'PT';
	} else {
		return false;
	}
	
	if ( $hours ) {
		$duration .= $hours . 'H';
	}
	
	if ( $minutes ) {
		$duration .= $minutes . 'M';
	}
	
	return $duration;
}
