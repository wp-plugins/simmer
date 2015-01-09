<?php
/**
 * The License Deactivate setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<fieldset>
	<legend class="screen-reader-text">
		<?php _e( 'Deactivate', Simmer::SLUG ); ?>
	</legend>
	<label for="simmer_license_deactivate">
		<input id="simmer_license_deactivate" name="simmer_license[deactivate]" type="checkbox" value="1" />
		<?php _e( 'Deactivate this Simmer license.', Simmer::SLUG ); ?>
	</label>
</fieldset>
