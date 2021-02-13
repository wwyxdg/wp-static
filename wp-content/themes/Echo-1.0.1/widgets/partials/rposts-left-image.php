<div class="list-item block">
    <div class="col-5 media media-3x2 rounded">
        <a href="<?php the_permalink() ?>" target="_blank" class="media-content " style="background-image: url('<?php echo echo_the_thumbnail(null, array('w' => 420, 'h' => 180)) ?>');"></a>
    </div>
    <div class="list-content">
        <div class="list-body">
            <a href="<?php the_permalink() ?>" target="_blank" class="list-title text-xs">
                <div class="h-2x"><?php the_title() ?> </div>
            </a>
        </div>
        <div class="list-footer  d-none d-lg-block mt-1">
            <div class="text-muted text-xs">
                <time class="d-inline-block"><?php echo timeago(get_gmt_from_date(get_the_time('Y-m-d G:i:s'))); ?></time>
            </div>
        </div>
    </div>
</div>