<?php
/**
 * Define the front-end styles class
 * 
 * @since 1.2.0
 * 
 * @package Simmer\Front_End
 */

// If this file is called directly, get outa' town.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Simmer_Front_End_Styles {
	
	/**
	 * Enqueue the front-end styles.
	 * 
	 * @since 1.2.0
	 */
	public function enqueue_styles() {
		
		// The main front-end stylsheet.
		wp_enqueue_style( 'simmer-plugin-styles', plugin_dir_url( __FILE__ ) . 'assets/styles.css', array(), Simmer::VERSION );
	}
	
	/**
	 * Add the custom front-end styles.
	 * 
	 * @since 1.2.0
	 */
	public function add_custom_styles() {
		
		$accent_color = get_option( 'simmer_recipe_accent_color', '000' );
		$accent_color = simmer_hex_to_rgb( $accent_color );
		$accent_color = implode( ', ', $accent_color );
		
		$text_color = get_option( 'simmer_recipe_text_color', '000' );
		$text_color = simmer_hex_to_rgb( $text_color );
		$text_color = implode( ', ', $text_color );
		
		?>
		
		<style>
			.simmer-embedded-recipe {
				color: rgb( <?php echo esc_html( $text_color ); ?> );
				background: rgba( <?php echo esc_html( $accent_color ); ?>, .01 );
				border-color: rgba( <?php echo esc_html( $accent_color ); ?>, 0.1 );
			}
			.simmer-recipe-details {
				border-color: rgba( <?php echo esc_html( $accent_color ); ?>, 0.2 );
			}
			.simmer-recipe-details li {
				border-color: rgba( <?php echo esc_html( $accent_color ); ?>, 0.1 );
			}
			.simmer-message {
				color: rgb( <?php echo esc_html( $text_color ); ?> );
				background: rgba( <?php echo esc_html( $accent_color ); ?>, .1 );
			}
		</style>
		
		<?php
		
		/**
		 * Do additional custom styles.
		 *
		 * @since 1.0.0
		 */
		do_action( 'simmer_custom_styles' );
	}
	
	/**
	 * Determine if the styles should be enqueued.
	 * 
	 * @since 1.2.0
	 * 
	 * @return bool $enable_styles Whether the styles should be enabled.
	 */
	public function enable_styles() {
		
		$enable_styles = get_option( 'simmer_enqueue_styles', true );
		
		/**
		 * Filter whether the styles should be loaded.
		 * 
		 * @since 1.2.0
		 * 
		 * @param bool $enable_styles Whether the styles are set to load.
		 */
		$enable_styles = (bool) apply_filters( 'simmer_enable_styles', $enable_styles );
		
		return $enable_styles;
	}
}
