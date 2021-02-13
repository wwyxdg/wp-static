<?php

class Menu_Cat extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget-sub-menu',
			'description' => __('Echo - Menu Cat', 'echo'),
		);
		parent::__construct( 'Menu_Cat', __('Echo - Menu Cat', 'echo'), $widget_ops );
	}

	public function form($instance) { 
		return $instance;
	}



	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$widget_id = 'widget_' . $args['widget_id'];
		$menu = get_field('menu', $widget_id);
		$title = get_field('title', $widget_id);

        echo $args['before_widget'];
	
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
?>

		<ul>
			<?php wp_nav_menu(array('container' => false, 'items_wrap' => '%3$s', 'menu' => $menu)) ?>
		</ul>

<?php
        echo $args['after_widget'];
	}
}

function reg_menu_cat() {
	register_widget("Menu_Cat");
}
add_action( 'widgets_init', 'reg_menu_cat');