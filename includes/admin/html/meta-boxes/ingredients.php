<?php
/**
 * The ingredients meta box HTML.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Ingredients
 */
?>

<?php wp_nonce_field( 'simmer_save_recipe_meta', 'simmer_nonce' ); ?>

<table width="100%" cellspacing="5" class="simmer-list-table ingredients">
	
	<thead>
		<tr>
			<th class="simmer-sort">
				<div class="dashicons dashicons-sort"></div>
			</th>
			<th><?php _e( 'Amount', Simmer::SLUG ); ?></th>
			<th><?php _e( 'Unit', Simmer::SLUG ); ?></th>
			<th><?php _e( 'Description', Simmer::SLUG ); ?></th>
			<th></th>
		</tr>
	</thead>
	
	<tbody>
		
		<?php // Get the recipe's ingredients.
		$ingredients = simmer_get_the_ingredients( get_the_ID(), 'raw' ); ?>
		
		<?php if ( ! empty( $ingredients ) ) : ?>
			
			<?php $count = 0; ?>
			
			<?php foreach ( $ingredients as $ingredient ) : ?>
				
				<tr class="simmer-ingredient simmer-row">
							
					<td class="simmer-sort">
						<span class="simmer-sort-handle dashicons dashicons-menu"></span>
					</td>
					<td class="simmer-amt">
						<input type="text" style="width:100%;" name="simmer_ingredients[<?php echo $count; ?>][amt]" value="<?php echo esc_html( $ingredient->amount ); ?>" placeholder="2" />
					</td>
					<td class="simmer-unit">
						<?php simmer_units_select_field( array(
							'name'     => 'simmer_ingredients[' . $count . '][unit]',
							'selected' => $ingredient->unit,
						), $ingredient->convert_amount_to_float( $ingredient->amount ) ); ?>
					</td>
					<td class="simmer-desc">
						<input type="text" style="width:100%;" name="simmer_ingredients[<?php echo $count; ?>][desc]" value="<?php echo esc_html( $ingredient->description ); ?>" placeholder="onions, diced" />
					</td>
					<td class="simmer-remove">
						<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="ingredient" title="Remove"></a>
					</td>
					
				</tr>
				
				<?php $count++; ?>
				
			<?php endforeach; ?>
			
		<?php else : ?>
			
			<tr class="simmer-ingredient simmer-row">
						
				<td class="simmer-sort">
					<span class="simmer-sort-handle dashicons dashicons-menu"></span>
				</td>
				<td class="simmer-amt">
					<input type="text" style="width:100%;" name="simmer_ingredients[0][amt]" value="" placeholder="2" />
				</td>
				<td class="simmer-unit">
					<?php simmer_units_select_field( array(
						'name' => 'simmer_ingredients[0][unit]',
					) ); ?>
				</td>
				<td class="simmer-desc">
					<input type="text" style="width:100%;" name="simmer_ingredients[0][desc]" value="" placeholder="onions, diced" />
				</td>
				<td class="simmer-remove">
					<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="ingredient" title="Remove"></a>
				</td>
				
			</tr>
			
		<?php endif; ?>
		
	</tbody>
	
	<tfoot>
		<tr class="simmer-actions">
			<td colspan="5">
				<a class="simmer-add-row button" data-type="ingredient" href="#">
					<span class="dashicons dashicons-plus"></span>
					<?php _e( 'Add an Ingredient', Simmer::SLUG ); ?>
				</a>
			</td>
		</tr>
	</tfoot>
	
</table>
