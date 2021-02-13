<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Echo
 */

get_header();
?>
	<main class="py-5">
		<div class="container">
			<div class="d-flex flex-column flex-fill h-v-75 text-center">
				<div class="m-auto">
					<div class="w-48 mx-auto my-4"><img src="<?php bloginfo('template_url'); ?>/images/loudly-crying-face.png"></div>
					<div class="font-theme display-2">404</div>
					<div class="text-muted">抱歉，没有你要找的内容</div>
				</div>
			</div>
		</div>
	</main>
	<?php
get_footer();