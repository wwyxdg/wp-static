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
 * @Last Modified time: 2019-11-04 14:25:57

*/

class Recommended_Posts extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'Recommended_Posts',
			'description' => __('Echo - Recommended Posts', 'echo'),
		);
		parent::__construct( 'Recommended_Posts', __('Echo - Recommended Posts', 'echo'), $widget_ops );
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
        $style = get_field('style', $widget_id);
		$type = get_field('type', $widget_id);
		$cat = get_field('cat', $widget_id);
		$days = get_field('days', $widget_id);

        echo $args['before_widget'];
	
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }

        switch ($type) {
			case 'latest':
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'      => $num,
					'ignore_sticky_posts' => 1,
					'date_query' => array(
						array(
							'after'     => $days.' days ago',
							'inclusive' => true,
						),
					),
					'category__in' => $cat
				);
				break;

			case 'rand':
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'           => $num,
					'orderby'             => 'rand',
					'category__in' => $cat,
					'date_query' => array(
						array(
							'after'     => $days.' days ago',
							'inclusive' => true,
						),
					),
					'ignore_sticky_posts' => 1
				);
				break;

			case 'comment':
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'           => $num,
					'orderby'             => 'comment_count',
					'category__in' => $cat,
					'ignore_sticky_posts' => 1,
					'date_query' => array(
						array(
							'after'     => $days.' days ago',
							'inclusive' => true,
						),
					),
				);
				break;

			case 'related':
				$queried_object_id = get_queried_object_id();
				$post_tags = get_the_tags($queried_object_id);
				$cats = get_the_category($queried_object_id);

				if ($post_tags) {
					$query_args = array(
						'posts_per_page' => $num,
						'orderby' => 'rand',
						'category__in' => $cat,
						'date_query' => array(
							array(
								'after'     => $days.' days ago',
								'inclusive' => true,
							),
						),
						'tax_query' => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'category',
								'field' => 'id',
								'terms' => array_column($cats, 'term_id')
							),
							array(
								'taxonomy' => 'post_tag',
								'field' => 'id',
								'terms' => array_column($post_tags, 'term_id'),
							)
						)
					);
				} else {
					$query_args = array(
						'posts_per_page' => $num,
						'orderby' => 'rand',
						'date_query' => array(
							array(
								'after'     => $days.' days ago',
								'inclusive' => true,
							),
						),
						'category__in' => $cat,
					);
				}

				break;

			case 'like':
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'      => $num,
					'orderby'             => 'meta_value_num',
					'meta_key'            => 'suxing_ding',
					'category__in' => $cat,
					'ignore_sticky_posts' => 1,
					'date_query' => array(
						array(
							'after'     => $days.' days ago',
							'inclusive' => true,
						),
					),
				);
				break;

			case 'view':
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'           => $num,
					'orderby'             => 'meta_value_num',
					'meta_key'            => 'views',
					'category__in' => $cat,
					'ignore_sticky_posts' => 1,
					'date_query' => array(
						array(
							'after'     => $days.' days ago',
							'inclusive' => true,
						),
					),
				);
				break;

			default:
				$query_args = null;
				break;
		}

		// $queryPosts = echo_get_cached_query('widget_recommended_posts_'.$this->id, $query_args, DAY_IN_SECONDS / 2);
		$queryPosts = new WP_Query($query_args);
		$class =  $style == 'left-image' ? 'list-grid' : 'list';
?>
    <?php if ($queryPosts->have_posts()) : ?>
		<div class="<?php echo $class ?>">
		<?php while ($queryPosts->have_posts()) : $queryPosts->the_post(); ?>
			<?php get_template_part('widgets/partials/rposts', $style) ?>
		<?php endwhile; ?>
		</div>
    <?php
        else:
			echo '<div class="bg-light py-4 text-center"><div class="w-28 mx-auto mb-2"><img src="'.get_bloginfo('template_url').'/images/face-with-tears-of-joy.png"></div>';
			echo '<div class="text-sm text-muted">'. __('Not found any posts...', 'echo') .'</div></div>';
        endif;
        wp_reset_postdata();
    ?>
<?php
        echo $args['after_widget'];
	}
}

function reg_Recommended_Posts() {
	register_widget("Recommended_Posts");
}
add_action( 'widgets_init', 'reg_Recommended_Posts');