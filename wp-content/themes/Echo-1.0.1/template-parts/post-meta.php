<?php
    $echo_option = get_option('echo_option');
    $category = get_the_category();
    // $meta_layout = $echo_option['meta_layout'];
?>
<div class="meta text-muted">
    <div>
        <i class="text-dark text-xl iconfont icon-Contact"></i>
        <span class="d-inline-block text-xs"><?php the_author_posts_link() ?></span>
        <i class="text-xs text-primary px-2">⋅</i>
        <time class="d-inline-block text-xs "><?php echo_the_time(); ?></time>
        <?php edit_post_link(__('Edit Post', 'echo'), '<span class="text-xs mx-2">', '</span>'); ?>
    </div>
    <!--div-- class="ml-auto text-sm">
				<a class="mx-2" href=""><i class="text-md iconfont icon-eye-line mx-1"></i><small>42</small></a>
				<a class="mx-2" href=""><i class="text-md iconfont icon-chat--line mx-1"></i><small>23</small></a>
				<a class="mx-2" href=""><i class="text-md iconfont icon-thumb-up-line mx-1"></i><small>645</small></a>
				<a class="mx-2" href=""><i class="text-md iconfont icon-share-circle-line mx-1"></i><small>64</small></a>
				<a class="mx-2" href=""><i class="text-md iconfont icon-qr-scan--line"></i></a>
			</!--div-->
</div>
<!-- <div class="meta d-flex align-items-center text-xs text-muted">
    <div>
        <span class="d-inline-block"><?php the_author_link() ?><i class="px-2">⋅</i></span>
        <time class="d-inline-block"><?php echo_the_time(); ?></time>
    </div>
    <div class="ml-auto text-sm">
        <a class="mx-2" href=""><i class="text-md iconfont icon-eye-line mx-1"></i><small><?php echo_post_views('', ''); ?></small></a>
        <?php if (comments_open()) : ?>
            <a class="mx-2" href="#comments"><i class="text-md iconfont icon-chat--line mx-1"></i><small><?php echo $post->comment_count; ?></small></a>
        <?php endif; ?>
        <?php $is_liked = isset($_COOKIE['suxing_ding_' . $post->ID]); ?>
        <a class="<?php if ($is_liked) echo 'current'; ?> mx-2 btn-like" href="javascript:;" data-action="<?php echo $is_liked ? 'unlike' : 'like' ?>" data-id="<?php the_ID(); ?>"><i class="text-md iconfont icon-thumb-up-line mx-1"></i><small class="like-count"><?php echo echo_get_hearts(get_the_ID()) ?></small></a>
        <a class="mx-2" href=""><i class="text-md iconfont icon-share-circle-line mx-1"></i><small>64</small></a>
        <a class="mx-2" href=""><i class="text-md iconfont icon-qr-scan--line"></i></a>
    </div>
</div> -->