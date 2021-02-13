<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * The template for displaying all single posts#single-post
 * Template Name: Full Page
 *
 * @package Echo
 */

get_header();
$category = get_the_category();
?>
<?php while (have_posts()) : the_post() ?>
	<main class="py-4 py-md-5">
		<div class="container">
			<div class="border-bottom border-light pb-4 pb-lg-4 mb-4 mb-lg-5">
				<h1 class="h3"><?php the_title() ?></h1>
			</div>
			<div class="post-content h-v-50">
				<?php the_content() ?>
			</div>
			<?php
				if (comments_open() || get_comments_number()) :
					comments_template();
				endif;
			?>
		</div>
	</main>
<?php endwhile; ?>
<?php
get_footer();
