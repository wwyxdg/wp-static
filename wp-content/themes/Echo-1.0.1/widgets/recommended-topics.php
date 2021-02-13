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
 * @Last Modified time: 2019-10-31 17:50:36

*/

class Recommended_Topics extends WP_Widget
{

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'Recommended_Topics',
			'description' => __('Echo - Recommended Topics', 'echo'),
		);
		parent::__construct('Recommended_Topics', __('Echo - Recommended Topics', 'echo'), $widget_ops);
	}

	public function form($instance)
	{
		return $instance;
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance)
	{
		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$widget_id = 'widget_' . $args['widget_id'];
		$title = get_field('title', $widget_id);

		echo $args['before_widget'];

		if ($title) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$topics_id = get_field('topics', $widget_id);
		?>
		<?php if (is_array($topics_id) && count($topics_id) > 0) : ?>
			<div class="list">
				<?php foreach ($topics_id as $topic_id) : ?>
					<?php $topic = get_term($topic_id); ?>
					<div class="list-item list-overlay rounded overlay-hover">
						<div class="media media-21x9 rounded">
							<a class="media-content" title="<?php echo $topic->name ?>" style="background-image: url('<?php echo timthumb(get_term_meta($topic->term_id, 'cover', true)) ?>');"><div class="overlay"></div></a>
						</div>
						<div class="media-overlay">
							<div class="m-auto px-2">
								<a href="<?php echo get_term_link($topic->term_id) ?>" class="list-title text-sm" target="_blank">
									<div class="h-2x"><?php echo $topic->name ?></div>
								</a>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php
				else :
					echo '<div class="bg-light py-4 text-center"><div class="w-28 mx-auto mb-2"><img src="'.get_bloginfo('template_url').'/images/face-with-tears-of-joy.png"></div>';
					echo '<div class="text-sm text-muted">'. __('Not found any posts...', 'echo') .'</div></div>';
				endif;
				wp_reset_postdata();
				?>
<?php
		echo $args['after_widget'];
	}
}

function reg_recommended_topics()
{
	register_widget("Recommended_Topics");
}
add_action('widgets_init', 'reg_recommended_topics');
