<?php
/**
 * The Ingredients List Type setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<?php $format = get_option( 'simmer_ingredients_list_type', 'ul' ); ?>

<fieldset>
	<label for="simmer_ingredients_list_type_ul" title="<?php _e( 'Bulleted List', Simmer()->domain ); ?>">
		<input id="simmer_ingredients_list_type_ul" name="simmer_ingredients_list_type" type="radio" value="ul" <?php checked( 'ul', $format ); ?> />
		<span><?php _e( 'Bulleted List', Simmer()->domain ); ?></span>
	</label><br>
	<label for="simmer_ingredients_list_type_ol" title="<?php _e( 'Numbered List', Simmer()->domain ); ?>">
		<input id="simmer_ingredients_list_type_ol" name="simmer_ingredients_list_type" type="radio" value="ol" <?php checked( 'ol', $format ); ?> />
		<span><?php _e( 'Numbered List', Simmer()->domain ); ?></span>
	</label>
</fieldset>
