<?php
/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-11 15:45:50
 * @Last Modified by: suxing
 * @Last Modified time: 2019-10-31 11:34:03

*/

class Hot_Tags extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'Hot_Tags',
			'description' => __('Echo - Hot Tags', 'echo'),
		);
		parent::__construct( 'Hot_Tags', __('Echo - Hot Tags', 'echo'), $widget_ops );
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
		$num = get_field('num', $widget_id);
		$title = get_field('title', $widget_id);

        echo $args['before_widget'];
	
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$tags = get_tags(array(
			'orderby' => 'count'
		));
?>
		<div class="row-xs my-n1">
			<?php foreach(array_slice($tags, 0, $num) as $tag): ?>
			<div class="col-xl-6 py-1">
					<div class="text-center">
						<a href="<?php echo get_term_link($tag, 'tag') ?>" target="_blank" title="<?php echo $tag->name ?>" class="btn btn-outline-light btn-sm btn-block"><span class="h-1x"><?php echo $tag->name ?></span></a>
					</div>
			</div>
			<?php endforeach; ?>
		</div>
<?php
        echo $args['after_widget'];
	}
}

function reg_Hot_Tags() {
	register_widget("Hot_Tags");
}
add_action( 'widgets_init', 'reg_Hot_Tags');