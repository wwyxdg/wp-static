<div class="list-item list-overlay overlay-hover">
    <div class="media media-21x9 rounded">
        <a href="<?php the_permalink() ?>" target="_blank" class="media-content" style="background-image:url('<?php echo echo_the_thumbnail(null, array('w' => 420, 'h' => 180)) ?>')">
            <div class="overlay"></div>
        </a>
    </div>
    <div class="list-content">
        <div class="list-body ">
            <a href="<?php the_permalink() ?>" target="_blank" class="list-title text-sm">
                <div class="h-2x"><?php the_title() ?></div>
            </a>
        </div>
    </div>
</div>