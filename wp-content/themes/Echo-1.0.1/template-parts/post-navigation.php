<?php $template_params = isset($template_params) ? $template_params : array() ?>
<?php if ($template_params['ajax_loading']): ?>
    <div class="list-ajax-load">
        <div class="ajax-loading text-center">
            <div class="spinner-border spinner-border-sm text-primary " role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <button
            type="button" 
            class="dposts-ajax-load btn btn-outline-light btn-block"
            data-page="<?php echo $template_params['page'] ?>"
            data-query="<?php echo $template_params['query']; ?>"
            data-action="ajax_load_posts"
            data-paged="2"
            data-append="<?php echo $template_params['append'] ?>"
        ><?php _e('Load more...', 'echo') ?></button>
    </div>
<?php else: ?>
    <?php
        the_posts_pagination( array(
            'prev_text'          =>'PREV',
            'next_text'          =>'NEXT',
            'screen_reader_text' => 'Posts Navigation',
            'mid_size' => 1,
        ) );
    ?>
<?php endif; ?>