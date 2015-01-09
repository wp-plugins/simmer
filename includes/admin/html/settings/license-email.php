<?php
/**
 * The License Email setting field.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Settings
 */
?>

<?php $license = new Simmer_License_Manager(); ?>

<?php if ( $license->is_active() ) : ?>
	
	<?php $license = get_option( 'simmer_license' ); ?>
	
	<?php echo esc_html( ( isset( $license['email'] ) ) ? $license['email'] : '' ); ?>
	
<?php else : ?>
	
	<input id="simmer_license_email" class="regular-text" name="simmer_license[email]" type="email" value="" />
	
<?php endif; ?>
