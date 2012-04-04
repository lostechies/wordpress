<h3 id="respond-title"><?php _e('Leave a Comment','padpressed') ?></h3>
<a href="#" class="close-comments-form close-form-btn">&215;</a>
<?php if ( comments_open() ) : ?>
	<?php do_action( 'comment_form_before' ); ?>
		<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
			<?php echo $args['must_log_in']; ?>
			<?php do_action( 'comment_form_must_log_in_after' ); ?>
		<?php else : ?>
			<form action="<?php echo '/wp-admin/admin-ajax.php?action=post_comment'; ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">				
				<input type="hidden" name="_ajax_post" value="<?php echo wp_create_nonce('ajaxnonce') ?>" id="_ajax_post">
				<?php if ( is_user_logged_in() ) : ?>
					<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
					<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
				<?php else : ?>
					<?php
					do_action( 'comment_form_before_fields' );
					foreach ( (array) $args['fields'] as $name => $field ) {
						echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
					}
					do_action( 'comment_form_after_fields' );
					?>
				<?php endif; ?>
				<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
				<div class="extra"><?php do_action( 'comment_form', $post_id ); ?></div>
				<p class="submit">
					<a href="#" class="cancel close-comments-form">Cancel</a>
					<a href="#" class="btn" id="post-comment-btn"><?php echo esc_attr( $args['label_submit'] ); ?></a>					
				</p>
				<?php comment_id_fields(); ?>
			</form>
		<?php endif; ?>
	<?php do_action( 'comment_form_after' ); ?>
<?php else : ?>
	<?php do_action( 'comment_form_comments_closed' ); ?>
<?php endif; ?>