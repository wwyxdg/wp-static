<?php
$prev_post = get_previous_post(false,'');
$next_post = get_next_post(false,'');
?>
<div class="border-top border-bottom border-light py-3 py-md-4 mt-4 mt-md-5 ">
    <div class="row">
    	<?php if( $prev_post ){ ?>
        <div class="col">
            <div class="text-left">
            <div class="text-muted mb-md-1"><a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="font-theme text-xl">PREV</a></div>
                <a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="d-none d-md-block text-sm"><div class="h-1x"><?php echo $prev_post->post_title; ?></div></a>
            </div>
        </div>
    	<?php } ?>
        <?php if( $next_post ){ ?>
        <div class="col">
            <div class="text-right">               
            <div class="text-muted mb-md-1"><a href="<?php echo get_permalink( $next_post->ID ); ?>" class="font-theme text-xl">NEXT</a></div>
                <a href="<?php echo get_permalink( $next_post->ID ); ?>" class="d-none d-md-block text-sm"><div class="h-1x"><?php echo $next_post->post_title; ?></div></a>
            </div>
        </div>
    	<?php } ?>
    </div>
</div>