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
	
	<?php $license = new Simmer_License(); ?>

	<?php if ( $license->is_active() ) : ?>
		
		<h2><?php _e( 'Recipe Extensions', Simmer()->domain ); ?></h2>
		
		<p><?php _e( 'Extend your business to whatever length you desire with Simmer. Purchase just the extensions you need, and shop around to fit your business\' goals.', Simmer()->domain ); ?></p>
		
		<div class="wp-list-table widefat simmer-extensions-list">
			
			<div class="simmer-extensions">
				
				<div class="simmer-extension-card">
					
					<div class="simmer-extension-card-top">
						
						<a href="http://simmerwp.dev/product/recipe-connector/" class="extension-icon" target="_blank">
							<img src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/assets/extensions/recipe-connector.png' ); ?>" width="128" height="128" />
						</a>
						
						<h4 class="extension-name">
							<a href="http://simmerwp.dev/product/recipe-connector/" target="_blank"><?php _e( 'Recipe Connector', Simmer()->domain ); ?></a>
						</h4>
						
						<a class="extension-get button button-primary" href="http://simmerwp.dev/product/recipe-connector/" target="_blank"><?php _e( 'Get', Simmer()->domain ); ?></a>
						
						<p class="extension-description"><?php _e( 'Attach individual recipes to a single blog post to keep your recipe database clear and concise', Simmer()->domain ); ?></p>
						
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
						
						<a href="http://simmerwp.dev/product/tinypass-for-simmer/" class="extension-icon" target="_blank">
							<img src="<?php echo esc_url( dirname( plugin_dir_url( __FILE__ ) ) . '/assets/extensions/simmer-tinypass.png' ); ?>" width="128" height="128" />
						</a>
						
						<h4 class="extension-name">
							<a href="http://simmerwp.dev/product/tinypass-for-simmer/" target="_blank"><?php _e( 'Tinypass for Simmer', Simmer()->domain ); ?></a>
						</h4>
						
						<a class="extension-get button button-primary" href="http://simmerwp.dev/product/tinypass-for-simmer/" target="_blank"><?php _e( 'Get', Simmer()->domain ); ?></a>
						
						<p class="extension-description"><?php _e( 'Tinypass for Simmer is an extension that allows WordPress websites to connect the power of micro e-commerce to monetize your food, drink, or recipe content instantly with Simmer.', Simmer()->domain ); ?></p>
						
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
		
		<h2><?php _e( 'Get the Most out of Simmer', Simmer()->domain ); ?></h2>
		
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
			
			<a class="button button-primary" href="https://simmerwp.com/pricing/" target="_blank">Purchase Now</a>
			
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
