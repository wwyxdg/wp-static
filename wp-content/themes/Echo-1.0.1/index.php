<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.

 *
 * @package Echo
 */
$echo_option = get_option('echo_option');
$ajax_loading = $echo_option['index_ajax_loading'];

$index_list_ad = $echo_option['index_list_ad'];
$index = 0;

get_header();
?>
	<?php get_template_part('template-parts/list-banner'); ?>
	<main class="py-4 py-md-5">
		<div class="container">
			<div class="row no-gutters">
				<?php get_sidebar('left') ?>
				<?php
				if ( have_posts() ) :
					?>
					<div class="col-md-9 col-lg-10 col-xl-7 pl-md-4 pl-lg-5 pl-xl-5 pr-xl-5">
						<div class="list-home list-border">
							<?php
								while ( have_posts() ) :
									$index++;
							?>
							<?php if ($index_list_ad['position'] == $index): ?>
								<?php get_template_part('template-parts/ad/index-list-ad') ?>
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
								'page' => 'home',
								'query' => '',
								'append' => 'list-home'
							));
						?>
					</div>
				<?php
					else :
						echo '<div class="col-lg-7 px-lg-5">';
						get_template_part( 'template-parts/error', 'none' );
						echo '</div>';
					endif;
				?>
				<?php get_sidebar() ?>
			</div>
		</div>
	</main>
<?php
get_footer();
