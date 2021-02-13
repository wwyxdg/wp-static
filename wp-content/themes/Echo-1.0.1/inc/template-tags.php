<?php
if ( ! function_exists( 'echo_get_logo_url' ) ) :
    function echo_get_logo_url() {
        $echo_option = get_option('echo_option');
        $logo = $echo_option['logo'];
        return empty($logo) ? get_template_directory_uri().'/images/logo.png' : timthumb($logo);
    }
endif;

if ( ! function_exists( 'echo_breadcrumbs' ) ) :
    function echo_breadcrumbs() {
        $echo_option = get_option('echo_option');
        $breadcrumbs = $echo_option['breadcrumbs'];
    
        if ($breadcrumbs):
            /* === OPTIONS === */
            $text['home']     = __('Home', 'echo'); // 首页
            $text['category'] = '%s'; // text for a category page
            $text['search']   = __('Search Result "%s"', 'echo'); // 搜索结果 "%s"
            $text['topic']      = __('Topic %s', 'echo'); // 文章标签
            $text['tag']      = __('Tag %s', 'echo'); // 文章标签
            $text['author']   = __('%s\'s Posts', 'echo'); // %s 的文章
            $text['404']      = __('404 Not Found', 'echo'); // 404 未找到
            $text['page']     = __('Page %s', 'echo'); // text 'Page N' 第 %s 页
            $text['cpage']    = __('Comment Page %s', 'echo'); // Comment Page %s
            $wrap_before      = '<div class="d-none d-md-block breadcrumbs text-muted mb-3">'; // the opening wrapper tag
            $wrap_after       = '</div>'; // the closing wrapper tag
            $sep              = '›'; // separator between crumbs
            $sep_before       = '<span class="sep">'; // tag before separator
            $sep_after        = '</span>'; // tag after separator
            $show_home_link   = 1; // 1 - show the 'Home' link, 0 - don't show
            $show_on_home     = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
            $show_current     = 1; // 1 - show current page title, 0 - don't show
            $before           = '<span class="current">'; // tag before the current crumb
            $after            = '</span>'; // tag after the current crumb
            /* === END OF OPTIONS === */
            global $post;
            $home_url       = home_url('/');
            $link_before    = '<span itemprop="itemListElement">';
            $link_after     = '</span>';
            $link_attr      = ' itemprop="item"';
            $link_in_before = '<span itemprop="name">';
            $link_in_after  = '</span>';
            $link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
            $frontpage_id   = get_option('page_on_front');
            $parent_id      = $post->post_parent;
            $sep            = ' ' . $sep_before . $sep . $sep_after . ' ';
            $home_link      = $link_before . '<a href="' . $home_url . '"' . $link_attr . ' class="home">' . $link_in_before . $text['home'] . $link_in_after . '</a>' . $link_after;
            if (is_home() || is_front_page()) {
                if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;
            } else {
                echo $wrap_before;
                if ($show_home_link) echo $home_link;
                if ( is_category() ) {
                    $cat = get_category(get_query_var('cat'), false);
                    if ($cat->parent != 0) {
                        $cats = get_category_parents($cat->parent, TRUE, $sep);
                        $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
                        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                        if ($show_home_link) echo $sep;
                        echo $cats;
                    }
                    if ( get_query_var('paged') ) {
                        $cat = $cat->cat_ID;
                        echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                    } else {
                        if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
                    }
                } elseif ( is_search() ) {
                    if (have_posts()) {
                        if ($show_home_link && $show_current) echo $sep;
                        if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
                    } else {
                        if ($show_home_link) echo $sep;
                        echo $before . sprintf($text['search'], get_search_query()) . $after;
                    }
                } elseif ( is_day() ) {
                    if ($show_home_link) echo $sep;
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
                    echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
                    if ($show_current) echo $sep . $before . get_the_time('d') . $after;
                } elseif ( is_month() ) {
                    if ($show_home_link) echo $sep;
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
                    if ($show_current) echo $sep . $before . get_the_time('F') . $after;
                } elseif ( is_year() ) {
                    if ($show_home_link && $show_current) echo $sep;
                    if ($show_current) echo $before . get_the_time('Y') . $after;
                } elseif ( is_single() && !is_attachment() ) {
                    if ($show_home_link) echo $sep;
                    if ( get_post_type() == 'news' ) {
                        $post_type = get_post_type_object(get_post_type());
                        $newscat = get_the_terms(get_the_ID(), 'news-category');
                        $slug = $post_type->rewrite;
                        printf($link, get_term_link($newscat[0]->term_id, 'news-category'), $newscat[0]->name);
                        if ($show_current) echo $sep . $before . get_the_title() . $after;
                    } elseif ( get_post_type() != 'post' ) {
                        $post_type = get_post_type_object(get_post_type());
                        $slug = $post_type->rewrite;
                        printf($link, $home_url . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                        if ($show_current) echo $sep . $before . get_the_title() . $after;
                    } else {
                        $cat = get_the_category(); $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, $sep);
                        if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
                        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                        echo $cats;
                        if ( get_query_var('cpage') ) {
                            echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
                        } else {
                            if ($show_current) echo $before . get_the_title() . $after;
                        }
                    }
                // custom post type
                } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                    $post_type = get_post_type_object(get_post_type());
                    if ( get_query_var('paged') ) {
                        echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                    } else {
                        if ($show_current) echo $sep . $before . $post_type->label . $after;
                    }
                } elseif ( is_attachment() ) {
                    if ($show_home_link) echo $sep;
                    $parent = get_post($parent_id);
                    $cat = get_the_category($parent->ID); $cat = $cat[0];
                    if ($cat) {
                        $cats = get_category_parents($cat, TRUE, $sep);
                        $cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
                        echo $cats;
                    }
                    printf($link, get_permalink($parent), $parent->post_title);
                    if ($show_current) echo $sep . $before . get_the_title() . $after;
                } elseif ( is_page() && !$parent_id ) {
                    if ($show_current) echo $sep . $before . get_the_title() . $after;
                } elseif ( is_page() && $parent_id ) {
                    if ($show_home_link) echo $sep;
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            if ($parent_id != $frontpage_id) {
                                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                            }
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        for ($i = 0; $i < count($breadcrumbs); $i++) {
                            echo $breadcrumbs[$i];
                            if ($i != count($breadcrumbs)-1) echo $sep;
                        }
                    }
                    if ($show_current) echo $sep . $before . get_the_title() . $after;
                } elseif ( is_tag() ) {
                    if ( get_query_var('paged') ) {
                        $tag_id = get_queried_object_id();
                        $tag = get_tag($tag_id);
                        echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                    } else {
                        if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
                    }
                } elseif ( is_tax() ) {
                    if ( get_query_var('paged') ) {
                        $tax_id = get_queried_object_id();
                        $tax = get_term($tax);
                        echo $sep . sprintf($link, get_term_link($tax_id), $tax->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                    } else {
                        if ($show_current) echo $sep . $before . sprintf($text['topic'], single_tag_title('', false)) . $after;
                    }
                } elseif ( is_author() ) {
                    global $author;
                    $author = get_userdata($author);
                    if ( get_query_var('paged') ) {
                        if ($show_home_link) echo $sep;
                        echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
                    } else {
                        if ($show_home_link && $show_current) echo $sep;
                        if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
                    }
                } elseif ( is_404() ) {
                    if ($show_home_link && $show_current) echo $sep;
                    if ($show_current) echo $before . $text['404'] . $after;
                } elseif ( has_post_format() && !is_singular() ) {
                    if ($show_home_link) echo $sep;
                    echo get_post_format_string( get_post_format() );
                }
                echo $wrap_after;
            }
        endif;
    }
endif;


if ( ! function_exists( 'echo_the_time' ) ) :
	function echo_the_time() {
		$echo_option = get_option('echo_option');
		$type = $echo_option['timestamp_type'];
		if ($type === 'sec' && is_single()) {
			echo get_the_time('Y-m-d G:i:s');
			return;
		}
		if ($type === 'eng') {
			echo get_the_time('F j, Y');
			return;
		}
		// 默认 ago
		echo echo_timeago();
		return;
	}
endif;

if ( ! function_exists( 'echo_get_time' ) ) :
	function echo_get_time($post = null) {
		$echo_option = get_option('echo_option');
		if ($post === null) global $post;
		$type = $echo_option['timestamp_type'];
		if ($type === 'sec' && is_single()) {
			return get_the_time('Y-m-d G:i:s', $post);
		}
		if ($type === 'eng') {
			return get_the_time('F j, Y', $post);
		}
		// 默认 ago
		return echo_timeago(null, $post);
	}
endif;

if ( ! function_exists( 'echo_comment_official' ) ) :
	function echo_comment_official( $user_id = null ){
		if( $user_id != null && $user_id == 1 ){
			printf( '<span class="badge badge-primary mr-2">%s</span>', __('Admin', 'echo'));
		}
	}
endif;


if ( ! function_exists( 'echo_the_author_comment_count' ) ) :
	function echo_author_comment_count($id, $echo = false) {
		$args = array(
			'post_type' => 'post',
			'author' => $id,
			'posts_per_page' => -1
		);
		$count = 0;
		$authorPosts = new WP_Query($args);

		while ($authorPosts->have_posts()) {
			$authorPosts->the_post();
			global $post;
			$count += (int) get_comments_number($post->ID);
		}

		wp_reset_postdata();
		if ($echo) echo format_big_numbers($count); else return $count;
	}
endif;