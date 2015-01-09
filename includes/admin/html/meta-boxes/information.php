<?php
/**
 * The ingredients meta box HTML.
 *
 * @package Simmer\Ingredients
 */
?>

<?php wp_nonce_field( 'simmer_save_recipe_meta', 'simmer_nonce' ); ?>

<?php // Build the formatted times.
$prep_time  = (int) simmer_get_the_time( 'prep',  $recipe->ID );
$cook_time  = (int) simmer_get_the_time( 'cook',  $recipe->ID );
$total_time = (int) simmer_get_the_time( 'total', $recipe->ID );

if ( $prep_time ) {
	$prep_h = zeroise( floor( $prep_time / 60 ), 2 );
	$prep_m = zeroise( ( $prep_time % 60 ), 2 );
} else {
	$prep_h = '';
	$prep_m = '';
}

if ( $cook_time ) {
	$cook_h = zeroise( floor( $cook_time / 60 ), 2 );
	$cook_m = zeroise( ( $cook_time % 60 ), 2 );
} else {
	$cook_h = '';
	$cook_m = '';
}

if ( $total_time ) {
	$total_h = zeroise( floor( $total_time / 60 ), 2 );
	$total_m = zeroise( ( $total_time % 60 ), 2 );
} else {
	$total_h = '';
	$total_m = '';
} ?>

<p>
	<label for="simmer_prep"><?php _e( 'Prep Time', Simmer::SLUG ); ?>:</label><br />
	<input class="simmer-time" name="simmer_times[prep][h]" type="number" min="0" value="<?php echo esc_html( $prep_h ); ?>" />
	:
	<input class="simmer-time" name="simmer_times[prep][m]" type="number" min="0" value="<?php echo esc_html( $prep_m ); ?>" />
</p>

<p>
	<label for="simmer_cook"><?php _e( 'Cook Time', Simmer::SLUG ); ?>:</label><br />
	<input class="simmer-time" name="simmer_times[cook][h]" type="number" min="0" value="<?php echo esc_html( $cook_h ); ?>" />
	:
	<input class="simmer-time" name="simmer_times[cook][m]" type="number" min="0" value="<?php echo esc_html( $cook_m ); ?>" />
</p>

<p>
	<label for="simmer_total"><?php _e( 'Total Time', Simmer::SLUG ); ?>:</label><br />
	<input class="simmer-time" name="simmer_times[total][h]" type="number" min="0" value="<?php echo esc_html( $total_h ); ?>" />
	:
	<input class="simmer-time" name="simmer_times[total][m]" type="number" min="0" value="<?php echo esc_html( $total_m ); ?>" />
</p>

<p>
	<label for="simmer_servings"><?php _e( 'Servings', Simmer::SLUG ); ?>:</label><br />
	<input type="text" name="simmer_servings" value="<?php echo esc_html( get_post_meta( $recipe->ID, '_recipe_servings', true ) ); ?>" placeholder="<?php _e( '3-4 people' ); ?>" />
</p>

<p>
	<label for="simmer_yield"><?php _e( 'Yield', Simmer::SLUG ); ?>:</label><br />
	<input type="text" name="simmer_yield" value="<?php echo esc_html( get_post_meta( $recipe->ID, '_recipe_yield', true ) ); ?>" placeholder="24 cookies" />
</p>

<?php $attribution_text = get_post_meta( $recipe->ID, '_recipe_attribution_text', true ); ?>
<?php $attribution_url  = get_post_meta( $recipe->ID, '_recipe_attribution_url',  true ); ?>
<p>
	<label for="simmer_attribution_text"><?php _e( 'Attribution', Simmer::SLUG ); ?>:</label><br />
	<input id="simmer_attribution_text" name="simmer_attribution_text" type="text" value="<?php echo esc_html( $attribution_text ); ?>" placeholder="Inspired by..." /><br />
	<label for="simmer_attribution_url"><?php _e( 'Attribution URL', Simmer::SLUG ); ?>:</label><br />
	<input id="simmer_attribution_url" name="simmer_attribution_url" type="text" value="<?php echo esc_url( $attribution_url ); ?>" placeholder="http://somesource.com" />
</p>
