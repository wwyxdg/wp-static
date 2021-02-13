<?php the_tags( '<div class="post-tags text-muted text-sm my-4"><span class="d-inline-block mr-2"># ', '</span><span class="d-inline-block mr-2"># ', '</span></div>' ); ?>
<div class="font-theme text-lg text-muted text-height-xs text-center my-5">
    - THE END -
</div>
<?php get_template_part('template-parts/post-share-section') ?>

<?php
    global $post;
    $post_copyright = get_post_meta(get_the_ID(), 'post_copyright', true);

    if ($post_copyright == 2) {
        $copyright_author = get_post_meta(get_the_ID(), 'post_copyright_name', true);
        $copyright_url = get_post_meta(get_the_ID(), 'post_copyright_link', true);
    }

    $is_open = get_the_modified_time( 'U' ) > get_the_time( 'U' ) || $post_copyright == 1 || $post_copyright == 2;
?>
<?php if ($is_open): ?>
<div class="post-lastedit text-xs text-muted bg-light rounded p-3 p-md-3 mt-4">
    <div class="d-flex flex-fill align-items-center">
        <i class="h1 text-secondary iconfont icon-Warning--circle mr-2"></i>
        <div class="flex-fill">
            <?php if ( get_the_modified_time( 'U' ) > get_the_time( 'U' ) ): ?>
                <div class="my-1">
                    <?php printf( esc_html__( 'The article is modified by @%s on %s.', 'echo' ), get_the_author_posts_link(), get_the_modified_date('Y-m-d', $post) ); ?>
                </div>
            <?php endif; ?>
            <?php if ($post_copyright == 1): ?>
                <div class="my-1"><?php printf( esc_html__( 'The article is originally written by @%s posted on %s. All rights reserved.', 'echo' ), get_the_author_posts_link(), get_bloginfo('name') ); ?>
                </div>
            <?php endif; ?>
            <?php if ($post_copyright == 2): ?>
                <div class="my-1"><?php printf( esc_html__( 'The article is written by @%s posted on %s. All rights reserved.', 'echo' ), "<a href='$copyright_url' target='_blank'>$copyright_author</a>", get_bloginfo('name') ); ?>
                </div>
            <?php endif; ?>

            
        </div>
    </div>
</div>
<?php endif; ?>
