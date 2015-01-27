<?php
/**
 * The License Key setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<?php $license = new Simmer_License(); ?>

<?php if ( $license->exists() ) : ?>
	
	<?php $status = $license->get_status(); ?>
	
	<span class="simmer-license-key-display"><code><?php echo esc_attr( $license->key ); ?></code></span>
	
	<span class="simmer-license-status-badge <?php echo esc_attr( $status ); ?>"><?php echo esc_attr( $status ); ?></span>
	
	<label for="simmer_license_deactivate">
		<input id="simmer_license_deactivate" name="simmer_license[deactivate]" type="checkbox" value="1" />
		<?php _e( 'Remove', Simmer::SLUG ); ?>
	</label>
	
<?php else : ?>
	
	<input id="simmer_license_key" class="regular-text code" name="simmer_license[key]" type="text" value="" />
	
<?php endif; ?>
