<?php $echo_option = get_option('echo_option') ?>
<?php if ($echo_option['related_posts']): ?>
<?php

    $post_tags = get_the_tags() ? get_the_tags() : array();
    $exclude_id = get_the_ID();
    $cats = get_the_category();

    $args = array(
        'type'                => 'post',
        'tax_query' => array(
            'relation' => 'OR',
            array(
                'taxonomy' => 'post_tag',
                'field' => 'id',
                'terms' => array_column($post_tags, 'term_id'),
            ),
            array(
            'taxonomy' => 'category',
                'field' => 'id',
                'terms' => array_column($cats, 'term_id'),
                'include_children' => false 
            )
        ),
        'post__not_in'        => array(get_the_ID()),
        'posts_per_page'      => $echo_option['related_posts_number'],
        'ignore_sticky_posts' => 1,
    );

    $recentPosts = echo_get_cached_query('recent_posts_query_'.get_the_ID(), $args);
?>
    <?php if ($recentPosts->have_posts()): ?>
    <div class="post-related mt-5 mt-md-5 ">
        <div class="h5 mt-md-0 mb-3 mb-lg-4"><span class=""><?php _e('Related Posts', 'echo') ?></span></div>
        <div class="list list-dots">
            <ul>
                <?php while ($recentPosts->have_posts()) : ?>
                    <?php $recentPosts->the_post(); ?>
                    <li class="my-2 my-md-3">
                        <a href="<?php the_permalink() ?>" target="_blank" class="list-title text-sm ">
                            <span class="h-1x"><?php the_title() ?></span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>