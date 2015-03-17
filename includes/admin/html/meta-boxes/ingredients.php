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
				<span class="hide-if-js">Order</span>
				<div class="dashicons dashicons-sort hide-if-no-js"></div>
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
			
			<?php foreach ( $ingredients as $order => $ingredient ) : ?>
				
				<tr class="simmer-ingredient simmer-row">
							
					<td class="simmer-sort">
						<input class="hide-if-js" style="width:100%;" type="text" name="simmer_ingredients[<?php echo $order; ?>][order]" value="<?php echo $order; ?>" />
						<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
					</td>
					<td class="simmer-amt">
						<input type="text" style="width:100%;" name="simmer_ingredients[<?php echo $order; ?>][amt]" value="<?php echo esc_html( $ingredient->amount ); ?>" placeholder="2" />
					</td>
					<td class="simmer-unit">
						<?php simmer_units_select_field( array(
							'name'     => 'simmer_ingredients[' . $order . '][unit]',
							'selected' => $ingredient->unit,
						), $ingredient->convert_amount_to_float( $ingredient->amount ) ); ?>
					</td>
					<td class="simmer-desc">
						<input type="text" style="width:100%;" name="simmer_ingredients[<?php echo $order; ?>][desc]" value="<?php echo esc_html( $ingredient->description ); ?>" placeholder="onions, diced" />
					</td>
					<td class="simmer-remove">
						<a href="#" class="simmer-remove-row dashicons dashicons-no" data-type="ingredient" title="Remove"></a>
					</td>
					
				</tr>
				
			<?php endforeach; ?>
			
		<?php else : ?>
			
			<tr class="simmer-ingredient simmer-row">
						
				<td class="simmer-sort">
					<input class="hide-if-js" style="width:100%;" type="text" name="simmer_ingredients[0][order]" value="0" />
					<span class="simmer-sort-handle dashicons dashicons-menu hide-if-no-js"></span>
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
	
	<tfoot class="hide-if-no-js">
		<tr class="simmer-actions">
			<td colspan="5">
				
				<a class="simmer-bulk-add-link hide-if-no-js" href="#" data-type="ingredient"><?php _e( '+ Add in Bulk', Simmer::SLUG ); ?></a>
				
				<a class="simmer-add-row button" data-type="ingredient" href="#">
					<span class="dashicons dashicons-plus"></span>
					<?php _e( 'Add an Ingredient', Simmer::SLUG ); ?>
				</a>
				
				<?php /**
				* Execute after the core action buttons have been rendered.
				* 
				* @since 1.2.0
				*/
				do_action( 'simmer_ingredients_admin_actions' ); ?>
				
			</td>
		</tr>
	</tfoot>
	
</table>
