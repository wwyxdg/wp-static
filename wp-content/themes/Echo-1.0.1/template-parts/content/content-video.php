<?php $category = get_the_category(); ?>
<main class="py-4 py-md-5">
    <div class="container">
        <div class="border-bottom border-light pb-3 pb-md-4 pb-lg-4 mb-3 mb-md-4 mb-lg-5">
            <?php get_template_part('template-parts/ad/single-head-ad'); ?>
            <a href="<?php echo get_category_link($category[0]); ?>" class="badge badge-primary badge-echo" target="_blank"><?php echo $category[0]->cat_name ?></a>
            <h1 class="h3 mt-2 mb-3"><?php the_title() ?></h1>
            <?php get_template_part('template-parts/post-meta') ?>
            <div class="post-video bg-dark mt-3 mt-md-4">
                
                <?php
                    $video_url = get_post_meta(get_the_ID(), 'video_url', true);
                    if (!empty($video_url)) {
                        echo apply_filters('the_content', $video_url);
                    }
                ?>
               
            </div>
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