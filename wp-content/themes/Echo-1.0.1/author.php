<?php
/**
 * The template for displaying archive pages

 *
 * @package Echo
 */
global $wp_query;

$echo_option = get_option('echo_option');
$author = get_queried_object();

$query = $author->ID;
$tpage = 'author';

$ajax_loading = $echo_option['archive_ajax_loading'];

$wpa_qq = get_user_meta($author->ID, 'qq', true);
$weixin = get_user_meta($author->ID, 'weixin', true);
$weibo = get_user_meta($author->ID, 'weibo', true);

get_header();
?>
<div class="bg-light text-center py-5">
	<div class="container">
		<div class="flex-avatar rounded-circle w-96 bg-dark mx-auto mb-3">
			<div class="avatar-status avatar-bottom"><span class="badge badge-pill badge-primary"><?php echo get_translated_role_name($author->ID) ?></span></div>
			<?php echo get_avatar( $author->ID, 96, '', '', array('class' => 'w-96') ); ?>
		</div>
		<div class="author-name h6 mb-2"><?php echo $author->display_name ?></div>
		<div class="author-data mb-3">
			<span class="text-xl mx-2"><i class="iconfont icon-Clipboard"></i><span class="font-theme text-md mx-1"><?php echo count_user_posts($author->ID) ?></span></span>
			<span class="text-xl mx-2"><i class="iconfont icon-Chat"></i><span class="font-theme text-md mx-1"><?php echo echo_author_comment_count($author->ID); ?></span></span>
		</div>
		<div class="author-desc text-sm text-muted px-md-5 mb-3"><?php echo $author->description ?></div>
		<?php if ($wpa_qq || $weixin || $weibo): ?>
		<div class="author-meta">
			<?php echo $wpa_qq ? '<a href="'.$wpa_qq.'" target="_blank" class="btn btn-icon btn-secondary btn btn-rounded btn-qq mx-1"><span><i class="text-md iconfont icon-qq"></i></span></a>' : '' ?>
			<?php echo $weixin ? '<a 
					href="javascript:" 
					class="single-popup btn btn-icon btn-secondary btn btn-rounded btn-weixin mx-1"
					data-img="'.timthumb($weixin).'"
					data-title="扫一扫加我微信"
					data-desc="'.$author->display_name.'"
					>
			<span><i class="text-md iconfont icon-wechat"></i></span></a>' : '' ?>
			<?php echo $weibo ? '<a href="'.$weibo.'" target="_blank" class="btn btn-icon btn-secondary btn btn-rounded btn-weibo mx-1"><span><i class="text-md iconfont icon-weibo"></i></span></a>' : '' ?>
		</div>
		<?php endif; ?>
	</div>
</div>
<main class="py-4 py-md-5">
	<div class="container">
		<div class="row justify-content-md-center">
			<?php
				if ( have_posts() ) :
					?>
				<div class="col-md-8 col-lg-7 px-md-5">
					<div class="list-archive list-border">
						<?php
							while ( have_posts() ) :
								the_post();
								get_template_part("template-parts/post-cards/card", get_post_format());
							endwhile;
						?>
					</div>
					<?php
						get_template_part_with_vars('template-parts/post-navigation', array(
							'ajax_loading' => $ajax_loading,
							'page' => $tpage,
							'query' => $query,
							'append' => 'list-archive'
						));
					?>
				</div>
			<?php
				else :
					get_template_part( 'template-parts/content', 'none' );
				endif;
			?>
		</div>
	</div>
</main>
<?php
get_footer();
