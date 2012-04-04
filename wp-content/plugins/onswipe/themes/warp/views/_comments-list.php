<?php 
switch ( $comment->comment_type ) :
	case '' :
?>
<div <?php comment_class('comment') ?> id="comment_<?php echo $comment->comment_ID ?>">
	<div class="author">
		<?php echo get_avatar( $comment, 24 ); ?>
		<span>
			<?php echo get_comment_author_link(); ?>
		</span>
		<em>
			<?php echo padpressed_relative_time($comment->date, sprintf( __( '%1$s at %2$s', 'padpressed' ), get_comment_date(),  get_comment_time() )) ?> 
		</em>
		<?php echo ($comment->comment_parent == 0) ? __('said','padpressed') : __('replied','padpressed') ?>
	</div>
	
	<?php if ( $comment->comment_approved == '0' ) : ?>
	<p class="awaiting"><?php _e( 'Your comment is awaiting moderation.', 'padpressed' ); ?></p>
	<?php endif; ?>

	<div class="content"><?php comment_text(); ?></div>

	<?php if (!$noreply): ?>
		<a href="#" class="comment-reply-link" <?php echo element_data(array('parentid'=>$comment->comment_ID, 'replyto'=>$comment->comment_author)) ?>>
			<?php _e('Reply') ?>
		</a>
	<?php endif ?>


</div><!-- #comment-##  -->

<?php
		break;
	case 'pingback'  :
	case 'trackback' :
?>
<div class="comment pingback">
	<p>
		<?php _e( 'Pingback:', 'padpressed' ); ?>			
		<?php comment_author_link(); ?>			
	</p>
</div>	
<?php
		break;
endswitch;