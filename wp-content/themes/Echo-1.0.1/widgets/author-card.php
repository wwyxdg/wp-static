<?php
class Author_Card extends WP_Widget
{

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'Author_Card',
			'description' => __('Echo - Author Card', 'echo'),
		);
		parent::__construct('Author_Card', __('Echo - Author Card', 'echo'), $widget_ops);
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

		echo $args['before_widget'];


		$wpa_qq = get_user_meta(get_the_author_meta('ID'), 'qq', true);
		$weixin = get_user_meta(get_the_author_meta('ID'), 'weixin', true);
		$weibo = get_user_meta(get_the_author_meta('ID'), 'weibo', true);

		if (get_the_author_meta('ID') > 0) :
			?>
			<div id="<?php echo $widget_id ?>" class="widget card bg-dark rounded mb-5">
				<div class="px-3 py-4">
					<div class="d-flex align-items-center justify-content-around">	
						<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank"  class="flex-avatar w-64">
							<?php echo get_avatar(get_the_author_meta('ID'), 64, '', '', array('class' => '')); ?>
						</a>
					</div>
					<div class="text-center mt-3">
						<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="h6 text-white"><?php the_author_meta('display_name') ?></a>
						<small class="d-block text-light mt-2"><?php the_author_meta('description') ?></small>
						<?php if ($wpa_qq || $weixin || $weibo): ?>
						<div class="mt-3">
							<?php echo $wpa_qq ? '<a href="'.$wpa_qq.'" target="_blank" class="text-light py-1 mx-2"><i class="iconfont icon-qq"></i></a>' : '' ?>
							<?php echo $weixin ? '<a 
									href="javascript:" 
									class="single-popup text-light py-1 mx-2"
									data-img="'.timthumb($weixin).'"
									data-title="扫一扫加我微信"
									data-desc="'.get_the_author_meta('display_name').'"
									>
							<i class="iconfont icon-wechat"></i></a>' : '' ?>
							<?php echo $weibo ? '<a href="'.$weibo.'" target="_blank" class="text-light py-1 mx-2"><i class="iconfont icon-weibo"></i></a>' : '' ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
<?php
		endif;
		echo $args['after_widget'];
	}
}

function reg_author_card()
{
	register_widget("Author_Card");
}
add_action('widgets_init', 'reg_author_card');
