<?php
/**
 * The Instructions List Type setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<?php $format = get_option( 'simmer_instructions_list_type', 'ol' ); ?>

<fieldset>
	<label for="simmer_instructions_list_type_ul" title="<?php _e( 'Bulleted List', Simmer::SLUG ); ?>">
		<input id="simmer_instructions_list_type_ul" name="simmer_instructions_list_type" type="radio" value="ul" <?php checked( 'ul', $format ); ?> />
		<span><?php _e( 'Bulleted List', Simmer::SLUG ); ?></span>
	</label><br>
	<label for="simmer_instructions_list_type_ol" title="<?php _e( 'Numbered List', Simmer::SLUG ); ?>">
		<input id="simmer_instructions_list_type_ol" name="simmer_instructions_list_type" type="radio" value="ol" <?php checked( 'ol', $format ); ?> />
		<span><?php _e( 'Numbered List', Simmer::SLUG ); ?></span>
	</label><br>
	<label for="simmer_instructions_list_type_p" title="<?php _e( 'Set of Paragraphs', Simmer::SLUG ); ?>">
		<input id="simmer_instructions_list_type_p" name="simmer_instructions_list_type" type="radio" value="p" <?php checked( 'p', $format ); ?> />
		<span><?php _e( 'Set of Paragraphs', Simmer::SLUG ); ?></span>
	</label>
</fieldset>
