<?php

/**
 * Enqueue scripts and styles.
 */
function echo_scripts() {
	$echo_option = get_option('echo_option');

	wp_enqueue_style( 'nicetheme-iconfont', get_template_directory_uri() . '/fonts/iconfont.css' );
	wp_enqueue_style( 'nicetheme-nicetheme', get_template_directory_uri() . '/css/nicetheme.css' );
	wp_enqueue_style( 'nicetheme-style', get_stylesheet_uri() );
	global $post;

	wp_localize_script( 'jquery', 'globals',
		array(
			"ajax_url"             => admin_url("admin-ajax.php"),
			"url_theme"            => get_template_directory_uri(),
			"site_url"             => get_bloginfo('url'),
			"post_id"			   => is_single() ? $post->ID : 0
		)
	);

	wp_localize_script( 'jquery', 'toc',
		array(
			'tag' => is_single() && get_post_meta($post->ID, 'toc', true) ? get_post_meta($post->ID, 'toc_tag', true) : 0
		)
	);



	wp_localize_script( 'jquery', '__',
		array(
			'load_more' => __('Load more...', 'echo'),
			'reached_the_end' => __('You\'ve reached the end.', 'echo'),
			'thank_you' => __('Thank you!', 'echo'),
			'success' => __('Success!', 'echo'),
			'cancelled' => __('Cancelled.', 'echo')
		)
	);

	wp_register_script( 'nicetheme-ajax-comments', get_template_directory_uri() . '/js/ajax-comment.js', array('jquery'), THEME_VERSION, true );
	if (!is_admin()) {
		//wp_enqueue_script( 'nicetheme-popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), THEME_VERSION, true );
		//wp_enqueue_script( 'nicetheme-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-plugins', get_template_directory_uri() . '/js/plugins.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-resizesensor', get_template_directory_uri() . '/js/ResizeSensor.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-sticky', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-js', get_template_directory_uri() . '/js/nicetheme.js', array('jquery'), THEME_VERSION, true );
		
		if (is_home()) {
			wp_enqueue_script( 'nicetheme-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), THEME_VERSION, true );
		}

		if ( is_singular() && comments_open() ) {
    		wp_enqueue_script( 'nicetheme-ajax-comments' );
        }

	}
}
add_action( 'wp_enqueue_scripts', 'echo_scripts' );