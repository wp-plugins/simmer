<?php
/**
 * The instructions meta box HTML.
 *
 * @package Simmer\Instructions
 */
?>

<?php wp_nonce_field( 'simmer_save_recipe_meta', 'simmer_nonce' );

$instructions = array();

$instructions = get_post_meta( $recipe->ID, '_recipe_instructions', true ); ?>

<table width="100%" cellspacing="5" class="simmer-list-table instructions">
	
	<thead>
		<tr>
			<th class="simmer-sort">
				<span class="hide-if-js">Order</span>
				<div class="dashicons dashicons-sort hide-if-no-js"></div>
			</th>
			<th><?php _e( 'Description', Simmer::SLUG ); ?></th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
		
		<tr class="simmer-heading simmer-row-hidden simmer-row">
			<td class="simmer-sort">
				<input class="hide-if-js" style="width:100%;" type="text" name="simmer_instructions[0][order]" value="0" />
				<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
			</td>
			<td class="simmer-desc">
				<input type="text" name="simmer_instructions[0][desc]" value="" /> <span class="simmer-heading-label"><?php _e( 'Heading', Simmer::SLUG ); ?></span>
				<input class="simmer-heading-input" type="hidden" name="simmer_instructions[0][heading]" value="true" />
			</td>
			<td class="simmer-remove">
				<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="heading" title="Remove"></a>
			</td>
		</tr>
		
		<?php if ( ! empty( $instructions ) ) :
			
			foreach ( $instructions as $order => $instruction ) :
				
				if ( isset( $instruction['heading'] ) && 1 === $instruction['heading'] ) : ?>
					
					<tr class="simmer-heading simmer-row">
						<td class="simmer-sort">
							<input class="hide-if-js" style="width:100%;" type="text" name="simmer_instructions[<?php echo $order; ?>][order]" value="<?php echo $order; ?>" />
							<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
						</td>
						<td class="simmer-desc">
							<input type="text" name="simmer_instructions[<?php echo $order; ?>][desc]" value="<?php echo $instruction['desc']; ?>" /> <span class="simmer-heading-label"><?php _e( 'Heading', Simmer::SLUG ); ?></span>
							<input class="simmer-heading-input" type="hidden" name="simmer_instructions[<?php echo $order; ?>][heading]" value="true" />
						</td>
						<td class="simmer-remove">
							<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="heading" title="Remove"></a>
						</td>
					</tr>
					
				<?php else : ?>
					
					<tr class="simmer-instruction simmer-row">
								
						<td class="simmer-sort">
							<input class="hide-if-js" style="width:100%;" type="text" name="simmer_instructions[<?php echo $order; ?>][order]" value="<?php echo $order; ?>" />
							<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
						</td>
						<td class="simmer-desc">
							<textarea style="width:100%;" name="simmer_instructions[<?php echo $order; ?>][desc]" placeholder="Preheat oven to 450 degrees. In a large bowl, mix stuff."><?php echo $instruction['desc']; ?></textarea>
							<input type="hidden" name="simmer_instructions[<?php echo $order; ?>][heading]" value="false" />
						</td>
						<td class="simmer-remove">
							<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="instruction" title="Remove"></a>
						</td>
						
					</tr>
					
				<?php endif; ?>
				
				<?php $count++;
				
			endforeach; ?>
			
		<?php else : ?>
			
			<tr class="simmer-instruction simmer-row">
				
				<td class="simmer-sort">
					<input class="hide-if-js" style="width:100%;" type="text" name="simmer_instructions[0][order]" value="0" />
					<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
				</td>
				<td class="simmer-desc">
					<textarea style="width:100%;" name="simmer_instructions[0][desc]" placeholder="Preheat oven to 450 degrees. In a large bowl, mix stuff."></textarea>
					<input type="hidden" name="simmer_instructions[0][heading]" value="false" />
				</td>
				<td class="simmer-remove">
					<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="instruction" title="Remove"></a>
				</td>
				
			</tr>
			
		<?php endif; ?>
		
	</tbody>
	
	<tfoot>
		<tr class="simmer-actions">
			<td colspan="3">
				<a class="simmer-add-row button" data-type="heading" href="#">
					<span class="dashicons dashicons-plus"></span>
					<?php _e( 'Add a Heading', Simmer::SLUG ); ?>
				</a>
				<a class="simmer-add-row button" data-type="instruction" href="#">
					<span class="dashicons dashicons-plus"></span>
					<?php _e( 'Add an Instruction', Simmer::SLUG ); ?>
				</a>
			</td>
		</tr>
	</tfoot>
	
</table>
