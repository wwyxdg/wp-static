<?php
    $s = new MiShare();
    $echo_option = get_option('echo_option');

    if ($echo_option['global_share'] === '0') return;

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

<template id="single-share-template">
    <div class="py-3 py-md-4">
        <div class="font-theme text-xl text-center mb-3">- SHARE THIS POST -</div>
        <div class="list-share text-center">
            <?php if ($bigger_cover == 1): ?>
                <a href="javascript:;" data-id="<?php the_ID(); ?>" id="btn-bigger-cover" class="btn-bigger-cover btn btn-icon btn-md btn-primary btn-rounded btn-download mx-1 my-2"><span><i class="text-md iconfont icon-Download"></i></span></a>
            <?php endif; ?>
            <?php if ($share_channel == 'all'): ?>
                <a href="<?php echo $s->weibo() ?>" target="_blank" class="btn btn-icon btn-md btn-light btn-rounded btn-weibo mx-1 my-2"><span><i class="text-md iconfont icon-weibo"></i></span></a>
                <a href="javascript:"  data-img="<?php echo $s->weixin() ?>" data-title="微信扫一扫 分享朋友圈" data-desc="在微信中请长按二维码" class="weixin single-popup btn btn-icon btn-md btn-light btn-rounded btn-weixin mx-1 my-2"><span><i class="text-md iconfont icon-wechat"></i></span></a>
                <a href="<?php echo $s->qq() ?>" target="_blank" class="btn btn-icon btn-md btn-light btn-rounded btn-qq mx-1 my-2"><span><i class="text-md iconfont icon-qq"></i></span></a>
                <a href="<?php echo $s->facebook() ?>" target="_blank" class="btn btn-icon btn-md btn-light btn-rounded btn-facebook mx-1 my-2"><span><i class="text-md iconfont icon-facebook"></i></span></a>
                <a href="<?php echo $s->linkedin() ?>" target="_blank" class="btn btn-icon btn-md btn-light btn-rounded btn-ins mx-1 my-2"><span><i class="text-md iconfont icon-instagram-alt"></i></span></a>
                <a href="<?php echo $s->twitter() ?>" target="_blank" class="btn btn-icon btn-md btn-light btn-rounded btn-twitter mx-1 my-2"><span><i class="text-md iconfont icon-twitter"></i></span></a>
            <?php endif; ?>
        </div>
    </div>
</template>