<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * The template for displaying all single posts#single-post
 * Template Name: Topic Page
 *
 * @package Echo
 */

get_header();
?>
<?php
	$topics_id = get_field('topics', get_the_ID());
?>
<?php while (have_posts()) : the_post() ?>
	<main class="py-4 py-md-5 h-v-50">
		<div class="container">
		<?php if(is_array($topics_id) && count($topics_id) > 0): ?>
			<div class="row list-topic list-grouped my-n4">
				<?php foreach($topics_id as $topic_id): ?>
					<?php $topic = get_term($topic_id['topic']); ?>
					<?php if ($topic->count > 0): ?>
						<?php $cover = get_term_meta($topic->term_id, 'cover', true) ?>
						<div class="col-12 col-md-6 d-md-flex py-4">
							<div class="list-item">
								<div class="list-content mb-3">
									<div class="list-body ">
										<a href="<?php echo get_term_link($topic->term_id) ?>" target="_blank" class="list-title h5 h-2x mb-2">
											<?php echo $topic->name ?>
										</a>
										<div class="text-sm text-muted h-2x"><?php echo $topic->description ?></div>
									</div>
								</div>
								<div class="media media-21x9 rounded">
									<a class="media-content bg-light" href="<?php echo get_term_link($topic->term_id) ?>" target="_blank" style="background-image:url('<?php echo timthumb($cover) ?>')"></a>
									<a class="media-overlay active bg-dark-overlay" href="<?php echo get_term_link($topic->term_id) ?>" target="_blank"><small class="font-theme text-xl text-white mx-auto"><?php echo $topic->count ?>+</small></a>

								</div>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		<?php
			else :
				get_template_part( 'template-parts/error-none' );
			endif;
		?>
		</div>
	</main>
<?php endwhile; ?>
<?php
get_footer();
