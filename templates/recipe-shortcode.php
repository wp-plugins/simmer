<?php
/**
 * Display the recipe when called by a shortcode
 * 
 * @since 1.1.0
 * 
 * @package Simmer/Shortcode
 */
?>

<div class="simmer-recipe" itemscope itemtype="http://schema.org/Recipe">
	
	<h1 class="simmer-recipe-title" itemprop="name">
		<a href="<?php the_permalink(); ?>"><?php echo esc_html( get_the_title() ); ?></a>
	</h1>
	
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
		
		<p class="simmer-recipe-description" itemprop="description"><?php echo get_the_excerpt(); ?></p>
		
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
	
	<div class="simmer-recipe-source">
		<?php simmer_the_source(); ?>
	</div>
	
</div>
