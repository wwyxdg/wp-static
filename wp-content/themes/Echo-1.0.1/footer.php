<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Echo
 */
$echo_option = get_option('echo_option');
$social_connect = $echo_option['social_connect'];
$footer_bottom = $echo_option['footer_bottom'];
$footer_text = $footer_bottom['footer_text'];
$miitbeian = $footer_bottom['miitbeian'];
$miitbeian_button = $footer_bottom['miitbeian_button'];
$gabeian_button = $footer_bottom['gabeian_button'];
$gabeian = $footer_bottom['gabeian'];
$gabeian_link = $footer_bottom['gabeian_link'];
$footer_links_title = isset( $footer_bottom['footer_links_title'] ) ? $footer_bottom['footer_links_title'] : '';
?>

<footer class=" text-center text-lg-left border-top border-light py-3 py-md-5">
	<div class="container">
		<div class="footer-top footer-siteinfo d-flex flex-fill align-items-lg-center flex-column flex-lg-row">
			<div class="flex-fill text-muted text-xs  order-2 order-lg-1">
				<?php
				if ($gabeian_button) : $footer_text .= ' <a href="' . $gabeian_link . '" target="_blank" rel="nofollow" class="d-none d-lg-inline-block"><i class="icon icon-beian"></i>' . $gabeian . '</a> ';
				endif;
				if ($miitbeian_button) : $footer_text .= ' <a href="http://beian.miit.gov.cn/" target="_blank" rel="nofollow" class="d-none d-lg-inline-block">' . $miitbeian . '</a>';
				endif;
				echo '<span class="d-inline-block">Copyright © ' . echo_get_footer_year() . ' <a class="text-muted" href="' . get_bloginfo('url') . '" title="' . get_bloginfo('name') . '" rel="home">' . get_bloginfo('name') . '</a>. All rights reserved.</span> <span class="d-inline-block">Designed by <a class="text-muted" href="https://www.nicetheme.cn" title="nicetheme奈思主题-资深的原创WordPress主题开发团队" target="_blank">nicetheme</a>.</span>' . $footer_text;
				?>
			</div>
			<div class="list-site-social d-lg-flex flex-lg-nowrap order-1 order-lg-2 mt-2 mt-md-0 mb-3 mb-lg-0">
				<?php if ($social_connect['weibo']) echo '<a href="'.$social_connect['weibo'].'" class="btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"><span><i class="text-md iconfont icon-weibo"></i></span></a>' ?>
				<?php if ($social_connect['weixin']['title'])
					echo '<a href="javascript:" 
					class="single-popup btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"
					data-img="'.timthumb($social_connect['weixin']['img']).'"
					data-title="'.$social_connect['weixin']['title'].'"
					data-desc="'.$social_connect['weixin']['desc'].'">
					<span><i class="text-md iconfont icon-wechat"></i></span></a>' ?>
				<?php echo $social_connect['qq'] ? '<a href="'.$social_connect['qq'].'" target="_blank" class="btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"><span><i class="text-md iconfont icon-qq"></i></span></a>' : ''; ?>
				<?php echo $social_connect['facebook'] ? '<a href="'.$social_connect['facebook'].'" target="_blank" class="btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"><span><i class="text-md iconfont icon-facebook"></i></span></a>' : ''; ?>
				<?php echo $social_connect['instagram'] ? '<a href="'.$social_connect['instagram'].'" target="_blank" class="btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"><span><i class="text-md iconfont icon-instagram-alt"></i></span></a>' : ''; ?>
				<?php echo $social_connect['twitter'] ? '<a href="'.$social_connect['twitter'].'" target="_blank" class="btn btn-icon btn-light btn-rounded mr-2 mr-lg-0 ml-lg-2"><span><i class="text-md iconfont icon-twitter"></i></span></a>' : ''; ?>
			</div>
		</div>
		
		<?php if (is_home() && $echo_option['links'] === '1'): ?>
			<div class="footer-bottom footer-sitelinks text-muted text-xs bg-light rounded p-3 p-md-3 p-lg-3 mt-3 mt-lg-5">
				<?php if ($echo_option['links_title']): ?><span class="mr-1"><?php echo $echo_option['links_title'] . ' : '  ?></span><?php endif; ?>
				<?php
					$bookmarks = get_bookmarks(array(
						'orderby' => 'rating',
						'category' => $echo_option['links_cat']
					));
				?>
				<?php foreach($bookmarks as $bookmark): ?>
					<a href="<?php echo $bookmark->link_url ?>" target="<?php echo $bookmark->link_target ?>"><?php echo $bookmark->link_name ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</footer>

<div class="mobile-sidebar">
	<div class="mobile-overlay"></div>
	<div class="mobile-menu">
		<ul>
			<?php
				if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('mobile-menu') ) {
					wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mobile-menu' ) );
				} 
			?>
		</ul>
	</div>
</div>
<div id="widget-to-top">
	<ul>
		<?php if (is_single()): ?>
			<?php if ($echo_option['global_share'] === '1'): ?><li class="my-2"><a class="btn-share-toggler btn btn-light btn-icon" href="javascript:"><span><i class="text-md iconfont icon-share_down"></i></span></a></li><?php endif; ?>
			<?php if ($echo_option['global_comments'] === '1'): ?><li class="my-2"><a class="btn-comment btn btn-light btn-icon" href="javascript:"><span><i class="text-md iconfont icon-Chat"></i></span></a></li><?php endif; ?>
		<?php endif; ?>
		<li class="my-2"><a class="btn btn-light btn-icon btn-totop" href="javascript:"><span><i class="text-md iconfont icon-Control"></i></span></a></li>
	</ul>
</div>
<?php get_template_part('template-parts/single-share') ?>
<?php get_template_part('template-parts/site-search') ?>
<?php wp_footer(); ?>
</body>

</html>