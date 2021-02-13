<li id="comment-<?php comment_ID() ?>" <?php comment_class(); ?>>
    <article id="div-comment-<?php comment_ID() ?>" class="d-flex flex-fill comment-body my-4 py-md-2">
        <div class="comment-avatar flex-avatar w-48 bg-light mr-3">
            <?php echo get_avatar( $comment, 48 ); ?>
        </div>
        <!-- .comment-author -->
        <div class="comment-content flex-fill flex-column">
            <div class="comment-author d-flex flex-fill align-items-center text-sm mb-1">
                <div class="flex-fill">
                    <?php comment_author_link() ?><span class="mx-1"></span><?php echo_comment_official( $comment->user_id ); ?>
                </div>
                <div>
                    <a onclick="return addComment.moveForm( 'comment-<?php comment_ID() ?>','<?php comment_ID() ?>', 'respond','<?php echo $comment->comment_post_ID; ?>' ) " href="?replytocom=<?php comment_ID() ?>#respond" class="text-muted comment-reply-link" rel="nofollow"><i class="text-lg iconfont icon-Chat1"></i></a>
                </div>
            </div>
            <div class="comment-meta text-xs text-muted mb-2">
                <time class="mr-3"><?php echo echo_timeago(get_comment_time('G', false) ) ?></time>
            </div>
            <div class="comment-content text-sm text-muted">
                <?php
                    comment_text();
                ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                <div class="tip-comment-check text-lg"><i class="iconfont icon-Warning--circle"></i><small><?php echo esc_html_e( 'Your comment is awaiting moderation.', 'echo' ) ?></small></div>
                <?php endif; ?>
            </div><!-- .comment-content -->
            
        </div><!-- .comment-text -->
    </article><!-- .comment-body -->
</li>