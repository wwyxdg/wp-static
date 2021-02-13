<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Echo
 */

/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断字符串后缀
 * @return string
 */
function echo_substr_ext($str, $start = 0, $length = 0, $charset = 'utf-8', $suffix = '') {
    if (function_exists("mb_substr")) {
         return mb_substr($str, $start, $length, $charset).$suffix;
    }
    elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

function echo_reverse_strrchr($haystack, $needle, $trail) {
	$length = (strrpos($haystack, $needle) + $trail);
    return strrpos($haystack, $needle) ? substr($haystack,0,$length) : false;
}

/**
 * 获取完整的句子
 */
function echo_print_excerpt($length, $post = null, $echo = true) {
	global $post;
	$text = $post->post_excerpt;

	if ( '' == $text ) {
		$text = get_the_content();
		$text = strip_shortcodes($text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
	}

	$text = strip_shortcodes($text);
	$text = strip_tags($text);

	$text = echo_substr_ext($text,0,$length);
	$excerpt = echo_reverse_strrchr($text, '。', 3);

	if( $excerpt ) {
		$result = strip_tags(apply_filters('the_excerpt',$excerpt)).'...';
	} else {
		$result = strip_tags(apply_filters('the_excerpt',$text)).'...';
	}
	if ($echo == true) echo $result; else return $result;
}

function echo_the_thumbnail($post = null, $size = array('w' => 630, 'h' => 270), $set = 'small') {
    echo timthumb(echo_post_thumbnail_src($post), $size, $set);
}

add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '<sub><i class="text-primary iconfont icon-tag"></i></sub>', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    } elseif (is_tax('special')) {
        $title = single_tag_title( '<sub><i class="text-primary iconfont icon-Bookmark"></i></sub>', false );
    }

    return $title;
});


/**
 * Load a component into a template while supplying data.
 *
 * @param string $slug The slug name for the generic template.
 * @param array $params An associated array of data that will be extracted into the templates scope
 * @param bool $output Whether to output component or return as string.
 * @return string
 */
function get_template_part_with_vars($slug, array $params = array(), $output = true) {
	if(!$output) ob_start();
	$template_file = locate_template("{$slug}.php", false, false);
    extract(array('template_params' => $params), EXTR_SKIP);
    require($template_file);
	if(!$output) return ob_get_clean();
}

add_action('wp_ajax_nopriv_echo_like', 'echo_like');
add_action('wp_ajax_echo_like', 'echo_like');
function echo_like() {
    global $wpdb,$post;
    $id = $_POST["id"];
    $action = $_POST["like_action"];
    $echo_raters = get_post_meta($id,'suxing_ding',true);
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;

    $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;

    if ($action == 'like') {
        $expire = time() + 99999999;
        if (!isset($_COOKIE['suxing_ding_'.$id])) {
            setcookie('suxing_ding_'.$id,$id,$expire,'/',$domain,false);
            if (!$echo_raters || !is_numeric($echo_raters)) {
                update_post_meta($id, 'suxing_ding', 1);
            } else {
                update_post_meta($id, 'suxing_ding', ($echo_raters + 1));
            }
        }
        do_action('echo_like', $id, $user_id);
    }
    if ($action == 'unlike') {
        $expire = time() - 1;
        if (isset($_COOKIE['suxing_ding_'.$id])) {
            setcookie('suxing_ding_'.$id,$id,$expire,'/',$domain,false);
            update_post_meta($id, 'suxing_ding', ($echo_raters - 1));
        }
        do_action('echo_unlike', $id, $user_id);
    }
    echo get_post_meta($id,'suxing_ding',true);
    die;
}

add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');
function ajax_comment_callback() {
    global $wpdb;
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
    $post = get_post($comment_post_ID);
    $post_author = $post->post_author;
    if ( empty($post->comment_status) ) {
        do_action('comment_id_not_found', $comment_post_ID);
        ajax_comment_err('Invalid comment status.');
    }
    $status = get_post_status($post);
    $status_obj = get_post_status_object($status);
    if ( !comments_open($comment_post_ID) ) {
        do_action('comment_closed', $comment_post_ID);
        ajax_comment_err(__( 'Sorry, comments are closed.', 'echo' ));
    } elseif ( 'trash' == $status ) {
        do_action('comment_on_trash', $comment_post_ID);
        ajax_comment_err(__( 'Unknown error.', 'echo' ));
    } elseif ( !$status_obj->public && !$status_obj->private ) {
        do_action('comment_on_draft', $comment_post_ID);
        ajax_comment_err(__( 'Unknown error.', 'echo' ));
    } elseif ( post_password_required($comment_post_ID) ) {
        do_action('comment_on_password_protected', $comment_post_ID);
        ajax_comment_err(__( 'Password protected.', 'echo' ));
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }

    $comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
    $comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
    $comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
    $user = wp_get_current_user();
    if ( $user->exists() ) {
        if ( empty( $user->display_name ) )
            $user->display_name=$user->user_login;
        $comment_author       = esc_sql($user->display_name);
        $comment_author_email = esc_sql($user->user_email);
        $comment_author_url   = esc_sql($user->user_url);
        $user_ID              = esc_sql($user->ID);

    } else {
        if ( get_option('comment_registration') || 'private' == $status )
            ajax_comment_err('<p>'.__('Sorry, you must be logged in to leave a comment', 'echo').'</p>'); // 抱歉，您必须登录后才能发表评论。
    }
    $comment_type = '';
    if ( get_option('require_name_email') && !$user->exists() ) {
        if ( 6 > strlen($comment_author_email) || '' == $comment_author )
            ajax_comment_err( '<p>'.__('Please fill in the required options (Name, Email).', 'echo').'</p>' ); // 错误：请填写必须的选项（姓名，电子邮件）。
        elseif ( !is_email($comment_author_email))
            ajax_comment_err( '<p>'.__('Please input a valid email address.', 'echo').'</p>' ); // 错误：请输入有效的电子邮件地址。
    }
    if ( '' == $comment_content )
        ajax_comment_err( '<p>'.__('Say something...', 'echo').'</p>' ); // 说点什么吧
    $dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
    if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
    $dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
    if ( $wpdb->get_var($dupe) ) {
        ajax_comment_err('<p>'.__('Please do not repeat your comments. :)', 'echo').'</p>'); // Do not repeat comments aha~似乎说过这句话了
    }

    if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
        $time_lastcomment = mysql2date('U', $lasttime, false);
        $time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
        $flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
        if ( $flood_die ) {
            ajax_comment_err('<p>'.__('You reply too fast. Take it easy.', 'echo').'</p>'); // 你回复太快啦。慢慢来。
        }
    }
    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

    $comment_id = wp_new_comment( $commentdata );


    $comment = get_comment($comment_id);
    do_action('set_comment_cookies', $comment, $user, true);
    $comment_depth = 1;
    $tmp_c = $comment;
    while($tmp_c->comment_parent != 0){
        $comment_depth++;
        $tmp_c = get_comment($tmp_c->comment_parent);
    }
    $GLOBALS['comment'] = $comment;
    get_template_part('comment');
    ?>
    <?php
        die();
}

function ajax_comment_err($a) {
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-Type: text/plain;charset=UTF-8');
    echo $a;
    exit;
}

add_action('wp_ajax_nopriv_ajax_load_comments', 'ajax_load_comments');
add_action('wp_ajax_ajax_load_comments', 'ajax_load_comments');
function ajax_load_comments() {

	global $wp_query;

	$type  = sanitize_text_field( $_POST['type'] );
	$paged = sanitize_text_field( $_POST['paged'] );

    $q = sanitize_text_field( $_POST['query'] );

    if( $paged < 1 || $paged > $_POST['commentcount'] ){
        wp_die();
    }

    if ($type === 'page') {
        $wp_query = new WP_Query( array( 'page_id' => $q, 'cpage' => $paged ) );
    }

    if ($type === 'post') {
        $wp_query = new WP_Query( array( 'p' => $q, 'cpage' => $paged ) );
    }

    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            comments_template();
        }
    }

	wp_reset_postdata();
	wp_die();
}


/**
 * ajax
 */
add_action('wp_ajax_nopriv_ajax_load_posts', 'ajax_load_posts');
add_action('wp_ajax_ajax_load_posts', 'ajax_load_posts');
function ajax_load_posts() {

	global $wp_query;

	$page  = sanitize_text_field( $_POST['page'] );
    $paged = sanitize_text_field( $_POST['paged'] );
    
    $echo_option = get_option('echo_option');

    if( $page == 'home' ){

        $masking_cats = $echo_option['masking_cats'];
        $args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 ) );

        if( is_array( $masking_cats ) ){
            $args['category__not_in'] = $masking_cats;
        }

		$queryPosts = new WP_Query( $args );
    }
    

	if( $page == 'cat' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'cat' => $q, 'ignore_sticky_posts' => 1 ) );
	}

	if( $page == 'tag' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'tag' => $q, 'ignore_sticky_posts' => 1 ) );
	}

	if( $page == 'search' ){
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_type' => 'post', 'post_status' => 'publish', 's' => $q, 'ignore_sticky_posts' => 1 ) );
    }
    
    if( $page == 'author' ) {
        $tabcid = isset($_POST['tabcid']) ? sanitize_text_field( $_POST['tabcid'] ) : 1;
        $q = sanitize_text_field( $_POST['query'] );

        $args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'author' => $q, 'ignore_sticky_posts' => 1 ) );
    }
    
    $queryPosts = new WP_Query($args);
    if ( $queryPosts->have_posts() ) {
        while ( $queryPosts->have_posts() ) {
            $queryPosts->the_post();
            get_template_part("template-parts/post-cards/card", get_post_format());
        }
    }

    wp_reset_postdata();
	wp_die();
}

function echo_get_head_img( $id, $size = array('w' => 900, 'h' => 300) ) {
    $img = get_post_meta($id, 'head_img_url', true);
    return !empty($img) ? timthumb($img, $size) : '';
}

function echo_get_banner_img( $id, $size = array('w' => 900, 'h' => 600) ) {
    $img = get_post_meta($id, 'head_img_url', true);
    return !empty($img) ? timthumb($img, $size) : timthumb(echo_post_thumbnail_src(), $size);
}

function get_translated_role_name($user_id) {
    $data  = get_userdata( $user_id );
    $roles = $data->roles;
    if ( in_array('administrator', $roles) ) {
        return __('Administrator', 'echo');
    } else if ( in_array('editor', $roles) ) {
        return __('Certified Editor', 'echo');
    } else if ( in_array('author', $roles) ) {
        return __('Special Author', 'echo');
    } else if ( in_array ('subscriber', $roles) ) {
        return __('Subscriber', 'echo');
    }

    return __('Contributor', 'echo');
}


// comment emoji

function echo_get_wpsmiliestrans() {
    global $wpsmiliestrans;
    $wpsmilies = array_unique($wpsmiliestrans);
    $output = '';
    foreach($wpsmilies as $alt => $src_path){
        $output .= '<a class="add-smily" data-smilies="'.$alt.'">
        '.wp_staticize_emoji($src_path).'
        </a>';
    }
    return $output;
}
function echo_smilies_reset() {
    global $wpsmiliestrans;
    // don't bother setting up smilies if they are disabled
    if ( !get_option( 'use_smilies' ) )
        return;
    $wpsmiliestrans = array(
        ':mrgreen:' => "\xf0\x9f\x98\xa2",
        ':neutral:' => "\xf0\x9f\x98\x90",
        ':smile:'   => "\xf0\x9f\x99\x82",
        ':???:'     => "\xf0\x9f\x98\x95",
        ':cool:'    => "\xf0\x9f\x98\x8e",
        ':grin:'    => "\xf0\x9f\x98\x80",
        ':idea:'    => "\xf0\x9f\x92\xa1",
        ':oops:'    => "\xf0\x9f\x98\xb3",
        ':razz:'    => "\xf0\x9f\x98\x9b",
        ':roll:'    => "\xf0\x9f\x99\x84",
        ':wink:'    => "\xf0\x9f\x98\x89",
        ':cry:'     => "\xf0\x9f\x98\xa5",
        ':eek:'     => "\xf0\x9f\x98\xae",
        ':lol:'     => "\xf0\x9f\x98\x86",
        ':mad:'     => "\xf0\x9f\x98\xa1",
        ':sad:'     => "\xf0\x9f\x99\x81",
        '8-)'       => "\xf0\x9f\x98\x8e",
        '8-O'       => "\xf0\x9f\x98\xaf",
        ':-('       => "\xf0\x9f\x99\x81",
        ':-)'       => "\xf0\x9f\x99\x82",
        ':-?'       => "\xf0\x9f\x98\x95",
        ':-D'       => "\xf0\x9f\x98\x80",
        ':-P'       => "\xf0\x9f\x98\x9b",
        ':-o'       => "\xf0\x9f\x98\xae",
        ':-x'       => "\xf0\x9f\x98\xa1",
        ':-|'       => "\xf0\x9f\x98\x90",
        ';-)'       => "\xf0\x9f\x98\x89",
        '8O'        => "\xf0\x9f\x98\xaf",
        ':('        => "\xf0\x9f\x99\x81",
        ':)'        => "\xf0\x9f\x99\x82",
        ':?'        => "\xf0\x9f\x98\x95",
        ':D'        => "\xf0\x9f\x98\x80",
        ':P'        => "\xf0\x9f\x98\x9b",
        ':o'        => "\xf0\x9f\x98\xae",
        ':x'        => "\xf0\x9f\x98\xa1",
        ':|'        => "\xf0\x9f\x98\x90",
        ';)'        => "\xf0\x9f\x98\x89",
        ':twisted:' => "\xf0\x9f\x98\x88",
        ':evil:'    => "\xf0\x9f\x91\xbf",
        ':arrow:'   => "\xe2\x9e\xa1",
        ':!:'       => "\xe2\x9d\x97",
        ':shock:'   => "\xf0\x9f\x98\xaf",
        ':?:'       => "\xe2\x9d\x93"
    );
}
add_action('init','echo_smilies_reset');