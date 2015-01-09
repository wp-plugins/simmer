<?php
/**
 * The License Key setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<?php $license = new Simmer_License_Manager(); ?>

<?php if ( $license = $license->is_active() ) : ?>
	
	<?php echo esc_html( $license->status_extra->order_key ); ?>
	
<?php else : ?>
	
	<input id="simmer_license_key" class="regular-text code" name="simmer_license[key]" type="text" value="" />
	
<?php endif; ?>
