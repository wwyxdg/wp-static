<?php $category = get_the_category(); ?>
<main class="py-4 py-md-5">
    <div class="container">
        <div class="border-bottom border-light pb-3 pb-md-4 pb-lg-4 mb-3 mb-md-4 mb-lg-4">
            <?php get_template_part('template-parts/ad/single-head-ad'); ?>
            <a href="<?php echo get_category_link($category[0]); ?>" class="badge badge-primary badge-echo" target="_blank"><?php echo $category[0]->cat_name ?></a>
            <h1 class="h3 mt-2 mb-2 mb-md-3"><?php the_title() ?></h1>
            <?php get_template_part('template-parts/post-meta') ?>
            <?php if (get_post_meta(get_the_ID(), 'head_img', true) === '1' && !empty(echo_get_head_img(get_the_ID()))): ?>
                <div class="media media-21x9 mt-3 mt-md-4">
                    <div class="media-content" style="background-image:url('<?php echo echo_get_head_img(get_the_ID(), array('w' => 840, 'h' => 360)) ?>')"></div>
                </div>
            <?php endif; ?>
        </div>
        <div class="row pt-lg-2">
            <div class="col-lg-9 pr-lg-5">
                <div class="post-content">
                    <?php the_content() ?>
                </div>
                <?php get_template_part('template-parts/post-footer') ?>
                <?php get_template_part('template-parts/ad/single-foot-ad'); ?>
                <?php get_template_part('template-parts/post-next-prev'); ?>
                
                <?php get_template_part('template-parts/related-posts') ?>
                <?php
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                ?>
            </div>
            <?php get_template_part('template-parts/single-sidebar-control') ?>
        </div>
    </div>
</main>