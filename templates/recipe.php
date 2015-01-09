<div class="simmer-recipe" itemscope itemtype="http://schema.org/Recipe">
	
	<h1 class="simmer-recipe-title" itemprop="name"><?php echo esc_html( get_the_title() ); ?></h1>
	
	<div class="simmer-recipe-meta">
		
		<meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>">
		<meta itemprop="author" content="<?php echo esc_html( get_the_author() ); ?>">
		
		<?php printf(
			__( 'Created by %1s on %2s', Simmer::SLUG ),
			get_the_author(),
			get_the_date()
		); ?>
		
	</div><!-- .simmer-recipe-date -->
	
	<ul class="simmer-recipe-details">
		
		<?php if ( $prep_time = simmer_get_the_prep_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'prep', get_the_ID() ) ); ?>
			
			<li><?php _e( 'Prep Time', Simmer::SLUG ); ?>: <meta itemprop="prepTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $prep_time ); ?></li>
			
		<?php endif; ?>
		
		<?php if ( $cook_time = simmer_get_the_cook_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'cook', get_the_ID() ) ); ?>
			
			<li><?php _e( 'Cook Time', Simmer::SLUG ); ?>: <meta itemprop="cookTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $cook_time ); ?></li>
			
		<?php endif; ?>
		
		<?php if ( $total_time = simmer_get_the_total_time() ) : ?>
			
			<?php $machine_time = simmer_format_machine_duration( simmer_get_the_time( 'total', get_the_ID() ) ); ?>
			
			<li><?php _e( 'Total Time', Simmer::SLUG ); ?>: <meta itemprop="totalTime" content="<?php echo esc_attr( $machine_time ); ?>"><?php echo esc_html( $total_time ); ?></li>
			
		<?php endif; ?>
		
		<?php if ( $servings = simmer_get_the_servings() ) : ?>
			
			<li><?php _e( 'Serves', Simmer::SLUG ); ?>: <span itemprop="recipeYield"><?php echo esc_html( $servings ); ?></span></li>
			
		<?php endif; ?>
		
		<?php if ( $yield = simmer_get_the_yield() ) : ?>
			
			<li><?php _e( 'Yield', Simmer::SLUG ); ?>: <span itemprop="recipeYield"><?php echo esc_html( $yield ); ?></span></li>
			
		<?php endif; ?>
		
	</ul>
	
	<?php simmer_list_ingredients(); ?>
	
	<?php simmer_list_instructions(); ?>
	
	<div class="simmer-recipe-attribution">
		<?php simmer_the_attribution(); ?>
	</div>
	
</div>
