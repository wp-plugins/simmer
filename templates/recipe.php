<div class="simmer-recipe-meta">
	
	<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
	<meta itemprop="url" content="<?php the_permalink(); ?>">
	
	<p class="simmer-recipe-byline">
		<?php printf(
			__( 'Created by %1s on %2s', Simmer::SLUG ),
			'<span itemprop="author">' . esc_html( get_the_author() ) . '</span>',
			get_the_date()
		); ?>
	</p>
	
</div><!-- .simmer-recipe-date -->

<div class="simmer-recipe-details">
	
	<ul class="simmer-recipe-timing">
		
		<?php if ( $prep_time = simmer_get_the_prep_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'prep', get_the_ID() ) ); ?>
			
			<li>
				<strong><?php _e( 'Prep Time', Simmer::SLUG ); ?>:</strong> 
				<meta itemprop="prepTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $prep_time ); ?>
			</li>
			
		<?php endif; ?>
		
		<?php if ( $cook_time = simmer_get_the_cook_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'cook', get_the_ID() ) ); ?>
			
			<li>
				<strong><?php _e( 'Cook Time', Simmer::SLUG ); ?>:</strong> 
				<meta itemprop="cookTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $cook_time ); ?>
			</li>
			
		<?php endif; ?>
		
		<?php if ( $total_time = simmer_get_the_total_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'total', get_the_ID() ) ); ?>
			
			<li>
				<strong><?php _e( 'Total Time', Simmer::SLUG ); ?>:</strong> 
				<meta itemprop="totalTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $total_time ); ?>
			</li>
			
		<?php endif; ?>
		
	</ul><!-- .simmer-recipe-timing -->
	
	<ul class="simmer-recipe-extras">
		
		<?php if ( $servings = simmer_get_the_servings() ) : ?>
			
			<li>
				<strong><?php _e( 'Serves', Simmer::SLUG ); ?>:</strong> 
				<span itemprop="recipeYield"><?php echo esc_html( $servings ); ?></span>
			</li>
			
		<?php endif; ?>
		
		<?php if ( $yield = simmer_get_the_yield() ) : ?>
			
			<li>
				<strong><?php _e( 'Yield', Simmer::SLUG ); ?>:</strong> 
				<span itemprop="recipeYield"><?php echo esc_html( $yield ); ?></span>
			</li>
			
		<?php endif; ?>
		
		<?php if ( $categories = get_the_term_list( get_the_ID(), simmer_get_category_taxonomy(), '', ', ' ) ) : ?>
			
			<li>
				<strong><?php _e( 'Category', Simmer::SLUG ); ?>:</strong> 
				<span itemprop="recipeCategory"><?php echo $categories; ?></span>
			</li>
			
		<?php endif; ?>
		
	</ul><!-- .simmer-recipe-extras -->
	
</div><!-- .simmer-recipe-details -->

<?php simmer_list_ingredients(); ?>

<?php simmer_list_instructions(); ?>

<div class="simmer-recipe-footer">
	
	<div class="simmer-recipe-source">
		<?php simmer_the_source(); ?>
	</div>
	
	<div class="simmer-recipe-tools">
		
		<ul>
			<li class="simmer-recipe-print simmer-icon-print">
				<a href="#"><?php _e( 'Print', Simmer::SLUG ); ?></a>
			</li>
			
			<?php /**
			 * Trigger to add more tools to the recipe footer.
			 * 
			 * @since 1.2.1
			 * 
			 * @param int $recipe_id The current recipe ID.
			 */
			do_action( 'simmer_recipe_tools', get_the_ID() );
			
			/**
			 * Trigger to add more tools to the single recipe footer.
			 * 
			 * @since 1.2.1
			 * 
			 * @param int $recipe_id The current recipe ID.
			 */
			do_action( 'simmer_recipe_tools_single', get_the_ID() ); ?>
			
		</ul>
		
	</div><!-- .simmer-recipe-tools -->
	
</div><!-- .simmer-recipe-footer -->
