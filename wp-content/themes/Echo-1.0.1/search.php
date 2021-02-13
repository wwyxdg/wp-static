<?php
/**
 * The template for displaying archive pages

 *
 * @package Echo
 */
global $wp_query;

$echo_option = get_option('echo_option');


$tpage = 'search';
$query = get_search_query();


$ajax_loading = $echo_option['archive_ajax_loading'];

get_header();
?>
<div class="bg-light text-center py-5">
	<div class="container">
		<h1 class="h2"><?php _e( 'Search: ', 'echo' ); ?></h1>
		<div class="text-sm text-muted">
			# <?php echo get_search_query(); ?> #
		</div>
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
			?>
				<div class="col-md-8 col-lg-7 px-md-5">
			<?php
					get_template_part( 'template-parts/content/content', 'none' );
			?>
				</div>
			<?php
				endif;
			?>
		</div>
	</div>
</main>
<?php
get_footer();
