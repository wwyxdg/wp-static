<?php $category = get_the_category(); ?>
<div class="list-item">
    <div class="list-content">
        <div class="list-body">
            <div class="list-title text-lg mb-2 mb-md-3">
                <a href="<?php the_permalink() ?>" class="h-2x">
                    <?php the_title() ?>
                </a>
            </div>
            <div class="list-meta text-xs text-muted mb-2 mb-md-3">
                <div class="d-flex flex-fill align-items-center">
                    <div>
                        <span class="d-inline-block">
                            <a href="<?php echo get_category_link( $category[0] ) ?>"><?php echo $category[0]->name; ?></a>
                            <i class="px-2">⋅</i>
                        </span>
                        <time class="d-inline-block"><?php echo_the_time() ?></time>
                    </div>
                    <div class="flex-fill"></div>
                    <?php if( is_sticky() ){ ?>
                        <div>
                            <span class="badge badge-danger badge-echo">推荐</span>
                        </div>
                	<?php } ?>
                </div>
            </div>
            <div class="media media-21x9 rounded mb-md-3">
                <a class="media-content" href="<?php the_permalink() ?>" title="<?php the_title() ?>" style="background-image:url('<?php echo_the_thumbnail() ?>')"></a>

                <?php if ('image' == get_post_format()): ?>
                <div class="media-overlay overlay-top pt-3 px-3">
                    <span class="btn btn-dark btn-icon btn-rounded ">
                        <span>
                            <i class="iconfont icon-Picture"></i>
                        </span>
                    </span>
                </div>
                <?php endif; ?>
                <?php if ('video' == get_post_format()): ?>
                <div class="media-overlay overlay-top pt-3 pl-3">
                    <span class="btn btn-dark btn-icon btn-rounded ">
                        <span>
                            <i class="iconfont icon-Video-camera"></i>
                        </span>
                    </span>
                </div>
                <?php endif; ?>
                <?php if ('audio' == get_post_format()): ?>
                <div class="media-overlay overlay-top pt-3 px-3">
                    <span class="btn btn-dark btn-icon btn-rounded ">
                        <span>
                            <i class="iconfont icon-Headphones"></i>
                        </span>
                    </span>
                </div>
                <?php endif; ?>
            </div>
            <div class="d-none d-md-block list-desc text-sm text-secondary h-2x">
                <p><?php echo_print_excerpt(100) ?></p>
            </div>
        </div>
    </div>
</div>