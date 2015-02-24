<?php
/**
 * Display the Recent Recipes widget admin markup
 * 
 * @since 1.1.0
 * 
 * @package Simmer\Widgets
 */
?>

<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', Simmer::SLUG ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
</p>

<p>
	<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of recipes to show:', Simmer::SLUG ); ?></label>
	<input type="number" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo esc_attr( $instance['number'] ); ?>" min="0" style="width:50px;"/>
</p>

<p>
	<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'show_dates' ); ?>" name="<?php echo $this->get_field_name( 'show_dates' ); ?>" <?php checked( $instance['show_dates'] ); ?> />
	<label for="<?php echo $this->get_field_id( 'show_dates' ); ?>"><?php _e( 'Display relative dates', Simmer::SLUG ); ?></label>
</p>
