<?php $echo_option = get_option('echo_option'); ?>
<?php if ($echo_option['index_featured_switch']) : ?>
    <section class="site-banner bg-light py-3 py-md-4 py-lg-5">
        <div class="container">
            <div class="row no-gutters">
                <?php if (!empty($echo_option['index_featured_posts_left']) && count($echo_option['index_featured_posts_left']) > 0) : ?>
                    <div class="banner-left col-12 col-lg-9">
                        <div class="banner-index banner-has-dots owl-carousel owl-theme">
                            <?php foreach($echo_option['index_featured_posts_left'] as $p): ?>
                                <div class="item">
                                    <div class="media media-21x9 rounded">
                                        <a href="<?php echo esc_url($p['link']['url']) ?>" target="_blank" class="media-content nc-no-lazy" style="background-image: url(<?php echo timthumb($p['image'], array('w' => 1050, 'h' => 450)) ?>)"></a>
                                        <?php if ($p['title']) : ?>
                                        <div class="media-overlay overlay-bottom p-2 p-lg-3">
                                            <div class="h5 h-2x">
                                                <a class="list-title text-white" href="<?php echo esc_url($p['link']) ?>" target="_blank">
                                                    <?php echo $p['title'] ?>
                                                </a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($echo_option['index_featured_posts_right']) && count($echo_option['index_featured_posts_right']) > 0) : ?>
                    <div class="banner-right col-12 col-lg-3 mt-2 mt-lg-0">
                        <div class="row-xs my-n1">
                            <?php foreach($echo_option['index_featured_posts_right'] as $p): ?>
                                <div class="col-4 col-md-4 col-lg-12 py-1">
                                    <div class="list-item list-overlay">
                                        <div class="media media-21x9 rounded">
                                            <a class="media-content" href="<?php echo esc_url($p['link']['url']) ?>" target="_blank" style="background-image: url(<?php echo timthumb($p['image'], array('w' => 700, 'h' => 300)) ?>);"></a>
                                            <?php if ($p['title']) : ?>
                                                <div class="media-overlay overlay-bottom p-1 p-md-2">
                                                    <div class="text-sm h-2x">
                                                        <a href="<?php echo esc_url($p['link']['url']) ?>" target="_blank" class="list-title">
                                                            <?php echo $p['title'] ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>