<?php

function onswipe_presscore_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'presscore' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'presscore' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf(
						    __( '%1$s on %2$s <span class="says">said:</span>', 'presscore' ),
						    sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
						    sprintf(
						        '<time pubdate datetime="%1$s">%2$s</time>',
						        get_comment_time( 'c' ),
						        /* translators: 1: date, 2: time */
						        sprintf( __( '%1$s at %2$s', 'presscore' ), get_comment_date( __( 'm/d/y' ) ), get_comment_time() )
						    )
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'presscore' ), '<span class="edit-link">', '</span>' ); ?>

					<a href="#" class="reply-link" data-id="<?php comment_ID(); ?>" data-author="<?php echo get_comment_author(); ?>">
						<img src="<?php echo ONSWIPE_PLUGIN_URL.'/presscore/assets/images/reply-icon.png' ?>" alt="" />
					</a>

				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'presscore' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>


		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

add_filter( 'comment_form_default_fields', 'onswipe_presscore_comment_fields' );
function onswipe_presscore_comment_fields( $fields ){

	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'author' => '<p class="comment-form-author"> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . 'placeholder="'. __( 'Name' ) . ( $req ? ' (required)' : '' ) .'"' .' /></p>',
		'email'  => '<p class="comment-form-email"> <input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . 'placeholder="'. __( 'Email' ) . ( $req ? ' (required)' : '' ) .'"' . ' /></p>',
		'url'    => '<p class="comment-form-url"> <input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="'.__( 'Website' ).'" /></p>',
	);


	return $fields;

}

add_filter( 'comment_form_defaults', 'onswipe_presscore_comment_args' );
function onswipe_presscore_comment_args( $args ){

	$args['comment_notes_before'] = '';
	$args['comment_notes_after']  = '';
	$args['comment_field']        = '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="30" rows="8" aria-required="true" placeholder="'.__( 'Your comment' ).'"></textarea></p>';


	return $args;

}
