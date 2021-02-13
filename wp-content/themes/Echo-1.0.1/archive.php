<?php
/**
 * The template for displaying archive pages

 *
 * @package Echo
 */
global $wp_query;

$echo_option = get_option('echo_option');

if (is_category() || is_archive() && !is_author()) {
	$tpage = 'cat';
	$query = $cat;
}
if (is_tag()) {
	$tpage = 'tag';
	$query = $wp_query->queried_object->name;
}

if (is_category()) $cat_list_ad = $echo_option['cat_list_ad'];
$index = 0;

$ajax_loading = $echo_option['archive_ajax_loading'];

get_header();
?>
<div class="archive-header bg-light text-lg-center py-5 py-lg-5">
	<div class="container">
		<h1 class="h2"><span><?php the_archive_title(); ?><sup class=" font-theme text-muted text-sm"><?php printf(__('%d', 'echo'), $wp_query->queried_object->count) ?></sup></span></h1>
		<?php the_archive_description( '<div class="text-sm mt-2 mt-lg-2">', '</div>' ); ?>
	</div>
</div>
<main class="py-4 py-md-5">
	<div class="container">
		<div class="row no-gutters">
			<?php
				if ( have_posts() ) :
					?>
				<?php get_sidebar('left') ?>
				<div class="col-md-9 col-lg-10 col-xl-7 pl-md-4 pl-xl-5 pr-xl-5">
					<div class="list-archive list-border">
						<?php
							while ( have_posts() ) :
								$index++;
						?>
						<?php if (is_category() && $cat_list_ad['position'] == $index): ?>
							<?php get_template_part('template-parts/ad/cat-list-ad') ?>
						<?php endif; ?>
						<?php
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
				<?php get_sidebar() ?>
			<?php
				else :
					get_template_part( 'template-parts/error-none' );
				endif;
			?>
		</div>
	</div>
</main>
<?php
get_footer();
