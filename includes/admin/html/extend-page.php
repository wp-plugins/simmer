<?php
/**
 * The extend page markup.
 * 
 * @since 1.0.0
 * 
 * @package Simmer\Extend
 */
?>

<div class="wrap">
	
	<?php
	/**
	 * Allow others to add to the top of the extend page.
	 *
	 * @since 1.0.0
	 */
	do_action( 'simmer_before_extend_page' ); ?>
	
	<?php $license = new Simmer_License_Manager(); ?>

	<?php if ( $license->is_active() ) : ?>
		
		<h2><?php _e( 'Recipe Extensions', Simmer::SLUG ); ?></h2>
		
		<p><?php _e( 'These extensions expand the functionality of Simmer.', Simmer::SLUG ); ?></p>
		
		<div class="wp-list-table widefat simmer-extensions-list">
			
			<div class="simmer-extensions">
				
				<div class="simmer-extension-card">
					
					<div class="simmer-extension-card-top">
						
						<a href="#" class="extension-icon"></a>
						
						<h4 class="extension-name">
							<a href="http://simmerwp.com/extensions-themes/" target="_blank"><?php _e( 'Recipe Connector', Simmer::SLUG ); ?></a>
						</h4>
						
						<a class="extension-get button button-primary" href="http://simmerwp.com/extensions-themes/" target="_blank"><?php _e( 'Get', Simmer::SLUG ); ?></a>
						
						<p class="extension-description"><?php _e( 'Quickly &amp; easily connect recipes to the blog posts you\'ve written about them.', Simmer::SLUG ); ?></p>
						
					</div><!-- .simmer-extension-card-top -->
					<?php /*
					<div class="simmer-extension-card-bottom">
						
						<div class="extension-rating">
							<div class="star-rating" title="4.0 rating based on 1,503 ratings">
								<span class="screen-reader-text">4.0 rating based on 1,503 ratings</span>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-empty"></div>
							</div><!-- .start-rating -->
							<span class="num-ratings">(1,503)</span>
						</div><!-- .extension-rating -->
						
						<div class="extension-meta">
							<div class="extension-updated">
								<strong>Last Updated:</strong>
								<span title="2014-11-14 4:17pm GMT">6 days ago</span>
							</div>
							<div class="extension-compatibility">
								<strong>Compatible</strong> with your version of Simmer
							</div>
						</div><!-- .extension-meta -->
						
					</div><!-- .simmer-extension-card-bottom -->
					*/ ?>
				</div><!-- .simmer-extension-card -->
				
				<div class="simmer-extension-card">
					
					<div class="simmer-extension-card-top">
						
						<a href="#" class="extension-icon"></a>
						
						<h4 class="extension-name">
							<a href="#"><?php _e( 'Tinypass for Simmer', Simmer::SLUG ); ?></a>
						</h4>
						
						<a class="extension-get button button-primary" href="http://simmerwp.com/extensions-themes/" target="_blank"><?php _e( 'Get', Simmer::SLUG ); ?></a>
						
						<p class="extension-description"><?php _e( 'Integrate the Tinypass service with Simmer to easily monetizing your recipes.', Simmer::SLUG ); ?></p>
						
					</div><!-- .simmer-extension-card-top -->
					<?php /*
					<div class="simmer-extension-card-bottom">
						
						<div class="extension-rating">
							<div class="star-rating" title="4.5 rating based on 427 ratings">
								<span class="screen-reader-text">4.5 rating based on 427 ratings</span>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-full"></div>
								<div class="star star-half"></div>
							</div><!-- .start-rating -->
							<span class="num-ratings">(427)</span>
						</div><!-- .extension-rating -->
						
						<div class="extension-meta">
							<div class="extension-updated">
								<strong>Last Updated:</strong>
								<span title="2014-11-14 4:17pm GMT">2 hours ago</span>
							</div>
							<div class="extension-compatibility">
								<strong>Compatible</strong> with your version of Simmer
							</div>
						</div><!-- .extension-meta -->
						
					</div><!-- .simmer-extension-card-bottom -->
					*/ ?>
				</div><!-- .simmer-extension-card -->
				
			</div><!-- .simmer-extensions -->
			
		</div><!-- .simmer-extensions-list -->
		
	<?php else : ?>
		
		<h2><?php _e( 'Coming Soon to Simmer', Simmer::SLUG ); ?></h2>
		
		<div class="simmer-coming-soon">
			
			<div class="licensing">
				
				<div class="dashicons dashicons-admin-plugins"></div>
				
				<h3>Yearly Licensing</h3>
				
				<p>Gain access to professional support, exclusive content, and other members-only benefits by purchasing a 1-year license for Simmer.</p>
				
			</div><!-- .licensing -->
			
			<div class="extensions">
				
				<div class="dashicons dashicons-cart"></div>
				
				<h3>Recipe Extensions</h3>
				
				<p>Extend your business to whatever length you desire with Simmer. Purchase just the extensions you need, and shop around to fit your business' goals.</p>
				
			</div><!-- .extensions -->
			
			<a class="button button-primary" href="http://simmerwp.com" target="_blank">Sign up at simmerwp.com for more details</a>
			
		</div><!-- .simmer-coming-soon -->
		
	<?php endif; ?>
	
	<?php
	/**
	 * Allow others to add to the bottom of the extend page.
	 *
	 * @since 1.0.0
	 */
	do_action( 'simmer_after_extend_page' ); ?>
	
</div>
