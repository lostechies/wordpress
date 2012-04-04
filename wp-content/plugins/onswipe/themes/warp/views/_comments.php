<?php global $t; ?>
<?php if ( post_password_required() ) : ?>
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'padpressed' ); ?></p>
<?php
		return;
	endif;
?>

<?php if ( have_comments() ) : ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
				<div class="navigation">
					<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'padpressed' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'padpressed' ) ); ?></div>
				</div> <!-- .navigation -->
	<?php endif; // check for comment navigation ?>
				<?php
					wp_list_comments( array( 
						'style'=>'div',
						'callback' => array($t,'commentsWalkerCallback') 
						
						) 
					);
				?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
				<div class="navigation">
					
					<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'padpressed' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'padpressed' ) ); ?></div>
				</div><!-- .navigation -->
	<?php endif; // check for comment navigation ?>

<?php else : // or, if we don't have comments:

	/* If there are no comments and comments are closed,
	 * let's leave a little note, shall we?
	 */
	if ( ! comments_open() ) :
?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'padpressed' ); ?></p>
	<?php else: ?>
		<p class="nocomments"><?php _e( 'No comments yet.', 'padpressed' ); ?></p>
		
	<?php endif; // end ! comments_open() ?>
<?php endif; // end have_comments() ?>
