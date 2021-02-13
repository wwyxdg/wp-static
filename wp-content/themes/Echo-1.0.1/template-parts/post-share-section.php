<?php
    $s = new MiShare();
    $echo_option = get_option('echo_option');
    $share_channel = $echo_option['share_channel'];
    $likes_count = echo_get_hearts(get_the_ID());
    $bigger_cover = get_field('api_generation_poster', 'options');
    global $post;

    $url = get_the_permalink(get_the_ID());
    $title = get_the_title();
    $image = echo_post_thumbnail_src();
    $description = echo_print_excerpt(150, $post, false);

    $s->config = array(
        'url' => $url,
        'title' => $title,
        'des'   => $description
    );
?>
<?php $is_liked = isset($_COOKIE['suxing_ding_' . $post->ID]); ?>
<div class="post-action text-center my-5">
    <?php if (comments_open() && $echo_option['global_comments'] === '1') : ?>
        <a href="javascript:;" class="btn btn-light btn-xl btn-icon btn-rounded btn-comment mx-2">
            <span class="flex-column text-height-xs">
                <i class="text-xl iconfont icon-Chat mx-1"></i>
                <small class="font-theme text-xs"><?php echo $post->comment_count ?></small>
            </span>
        </a>
    <?php endif; ?>
    <?php if ($echo_option['global_likes'] === '1'): ?>
    <a href="javascript:;" data-action="<?php echo $is_liked ? 'unlike' : 'like' ?>" data-id="<?php the_ID(); ?>" class="btn btn-light btn-xl btn-icon btn-rounded btn-like mx-2 <?php echo $is_liked ? 'current' : ''; ?>">
        <span class="flex-column text-height-xs">
            <i class="text-xl iconfont icon-Like mx-1"></i>
            <small class="font-theme text-xs like-count"><?php echo $likes_count; ?></small>
        </span>
    </a>
    <?php endif; ?>
    <?php if ($echo_option['global_share'] === '1'): ?>
    <a href="javascript:;" class="btn btn-light btn-xl btn-icon btn-rounded btn-share-toggler mx-2"><span class="flex-column text-height-xs"><i class="text-xl iconfont icon-share_down mx-1"></i><small class="font-theme text-xs">share</small></span></a>
    <?php endif; ?>
</div>