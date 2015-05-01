<?php
/**
 * Display the bulk add modal
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Admin
 */
?>

<div class="simmer-bulk-modal-background"></div>
<div class="simmer-bulk-modal-wrap">
	
	<form id="simmer-bulk-add-form" tabindex="-1">
		
		<div class="simmer-bulk-modal-header">
			<span class="simmer-bulk-modal-title"><?php echo _e( 'Add In Bulk', Simmer()->domain ); ?></span>
			<button class="simmer-bulk-modal-close">
				<span class="screen-reader-text"><?php _e( 'Close', Simmer()->domain ); ?></span>
			</button>
		</div>
		
		<div class="simmer-bulk-modal-content">
			
			<?php wp_nonce_field( 'simmer_process_bulk', 'simmer_process_bulk_nonce' ); ?>
			
			<p class="simmer-bulk-help"><?php _e( 'Type or copy/paste the list of items below, one item per line.', Simmer()->domain ); ?></p>
			
			<textarea class="simmer-bulk-text" name="simmer-bulk-text" rows="8"></textarea>
			
		</div>
		
		<div class="simmer-bulk-modal-footer submitbox">
			<div class="cancel">
				<a class="submitdelete" href="#"><?php _e( 'Cancel', Simmer()->domain ); ?></a>
			</div>
			<div class="simmer-submit-bulk">
				<span class="spinner"></span>
				<button class="button button-primary"><?php _e( 'Add', Simmer()->domain ); ?></button>
			</div>
		</div>
		
	</form>
	
</div>
