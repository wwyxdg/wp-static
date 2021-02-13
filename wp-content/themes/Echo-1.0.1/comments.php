<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.

 *
 * @package Echo
 */
$echo_option = get_option('echo_option');
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
$user_ID = get_current_user_id();
if ($echo_option['global_comments'] === '0') return;

if ( post_password_required() ) {
	return;
}
if( isset($_POST['action']) && $_POST['action'] == 'ajax_load_comments' ){
    wp_list_comments('avatar_size=48&type=comment&callback=echo_comment&end-callback=echo_end_comment&max_depth=2');
    die();
}
?>
	<div id="comments" class="post-comments fade mt-5 mt-md-5 ">
		<div class="h5 mb-3 mb-lg-4">
			<?php
				$echo_comment_count = get_comments_number();
				echo _e( '<span>Comments</span>', 'echo' );
				echo ' <small class="font-theme text-sm text-muted">('.number_format_i18n( $echo_comment_count ).')</small>';
			?>
		</div>
		<?php if ( comments_open() ) : ?>
			<div id="respond" class="comment-respond mb-5">
			<?php if( get_option('comment_registration') && !$user_ID ) : ?>
				<div class="logged-in-as rounded bg-light text-center p-4 p-md-5 ">
					<p class="mb-3"><?php _e( 'Please login to leave a comment.', 'echo' ) ?></p>
					<a class="btn btn-secondary btn-sm" href="<?php echo wp_login_url(get_the_permalink()); ?>"><?php _e( 'Login now.', 'echo' ) ?></a>
				</div>
			<?php else : ?>
				<form method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" id="commentform" class="comment-form">
					<div class="d-flex flex-fill">
						<div class="comment-avatar flex-avatar w-48 bg-secondary mr-3">
						<?php
							if ( $user_ID ) {
								echo get_avatar( $user_ID, 48 );
							} else if ( $comment_author_email != '' ){
								echo get_avatar( $comment_author_email, 48 );
							} else {
								echo !empty($echo_option['default_comment_avatar']) ? 
									'<img src="'.timthumb($echo_option['default_comment_avatar']).'" class="avatar">' :
									'<img src="'.get_template_directory_uri().'/images/default-avatar.png'.'" class="avatar">';
							}
						?>
						</div>
						<div class="flex-fill">
							<div class="comment-form-body d-flex flex-fill align-items-center bg-light rounded-pill p-2 ">
								<div class="form-group comment-form-textarea flex-fill m-0">
									<textarea id="comment" name="comment" class="form-control rounded-pill" rows="1"></textarea>
								</div>
								<div class="form-submit comment-form-action d-flex flex-nowrap mx-1">
									<a id="cancel-comment-reply-link" style="display: none" class="btn btn-link btn-icon btn-rounded mr-1 mr-md-2" href="javascript:;">
										<span>
											<i class="text-md iconfont icon-error"></i>
										</span>
									</a>
									<?php if (has_action( 'wp_head', 'print_emoji_detection_script' )): ?>
									<span class="comment-smilies-inner mr-2 mr-md-3">
										<button type="button" class="btn btn-secondary btn-icon btn-rounded btn-comment-smilies " type="button">
											<span>
												<i class="text-md iconfont icon-Smile"></i>
											</span>
										</button>
									</span>
									<?php endif; ?>
									<button name="submit" type="submit" id="submit" class="btn btn-primary btn-icon btn-rounded" value="<?php _e( 'Submit', 'echo' ) ?>">
										<span>
											<i class="text-md iconfont icon-Send"></i>
										</span>
									</button>
									<?php comment_id_fields(); ?>
								</div>
								<?php if (has_action( 'wp_head', 'print_emoji_detection_script' )): ?>
									<div class="comment-form-smilies fadeup"><?php echo echo_get_wpsmiliestrans();?></div>
								<?php endif; ?>
							</div>
							<?php if ( ! $user_ID ): ?>
							<div class="comment-form-info mt-3">
								<div class="row-sm">
									<div class="col-md-4">
										<div class="form-group comment-form-author mb-md-0">
											<input class="form-control rounded-pill" id="author" placeholder="<?php _e( 'Nickname', 'echo' ) ?>" name="author" type="text" value="<?php echo $comment_author; ?>" required="required">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group comment-form-email mb-md-0">
											<input class="form-control rounded-pill" id="email" placeholder="<?php _e( 'Email', 'echo' ) ?>" name="email" type="email" value="<?php echo $comment_author_email; ?>">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group comment-form-url mb-md-0">
											<input class="form-control rounded-pill" id="url" placeholder="<?php _e( 'Website', 'echo' ) ?>" name="url" type="url" value="<?php echo $comment_author_url; ?>">
										</div>
									</div>
								</div>
							</div>
							<?php endif; ?>
							
						</div>
					</div>
				</form>
			<?php endif; ?>
			</div>
			<ul class="comment-list">
				<?php
					wp_list_comments('type=comment&callback=echo_comment&end-callback=echo_end_comment&max_depth=2');
				?>
			</ul>
			<?php if (get_comment_pages_count() > 1): ?>
				<div class="comment-ajax-load mt-4">
					<button
						id="comments-next-button"
						<?php if (is_page()): ?>
							data-type="page"
						<?php endif; ?>
						<?php if (is_single()): ?>
							data-type="post"
						<?php endif; ?>
						data-query="<?php the_ID(); ?>"
						data-action="ajax_load_comments"
						data-paged="<?php echo get_next_page_number(); ?>"
						data-commentcount="<?php echo get_comment_pages_count(); ?>"
						data-commentspage="<?php echo get_option( 'default_comments_page' ); ?>"
						data-append="comment-list"
						class="btn btn-light btn-block text-sm"><?php esc_html_e( 'Load more...', 'echo' ); ?></button>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="content-error text-center py-5">
				<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'echo' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
<!-- #comments -->
