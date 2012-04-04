<?php
	global $blog_id;

	if($blog_id == 1)
	{	
		$blog_list = $wpdb->get_results( "SELECT blog_id, last_updated FROM " . $wpdb->blogs. " WHERE public = '1' ", ARRAY_A );	
		$querystr = "";
		 
		foreach($blog_list as $blog)
		{
			$blogPrefix = $wpdb->get_blog_prefix($blog["blog_id"]);
			$querystr .= $querystr == "" ? "" : " UNION ALL ";
			$querystr .= "
				SELECT *, '".$blog["blog_id"]."' as blog_id
				FROM  ".$blogPrefix."posts 
				WHERE post_status = 'publish' 
				AND post_type = 'post' ";
		}		
			
	}	
	else 
	{
			$blogPrefix = $wpdb->get_blog_prefix($blog_id);		
			$querystr .= "
				SELECT *, '".$blog["blog_id"]."' as blog_id
				FROM  ".$blogPrefix."posts 
				WHERE post_status = 'publish' 
				AND post_type = 'post' ";
	}
	
		$querystr .= " ORDER BY post_date DESC LIMIT ";
		
		$querystr .= ($page == "" ? 0 : $page * 10) .", 10";		
		
		$wp_query->request = $querystr;	
		$pageposts = $wpdb->get_results($wp_query->request, OBJECT);	
		$attr = apply_filters( 'previous_posts_link_attributes', '' );
		
		$next_link = count($pageposts) > 4 ? '<a href="?page='. ($page + 1) . "\" $attr>". preg_replace( '/&([^#])(?![a-z]{1,8};)/', '&#038;$1', ' Next Page &raquo;' ) .'</a>' : "";	
		$prev_link = $page > 0 ? '<a href="?page='.($page - 1) . "\" $attr>". preg_replace( '/&([^#])(?![a-z]{1,8};)/', '&#038;$1', '&laquo; Previous Page' ) .'</a>' : "";	
				
?>

	<div id="nav-above" class="navigation">
<?php if ( $prev_link <> "" ) : ?>
		<div class="nav-previous"><?php echo $prev_link ?></div>
<?php endif; ?>
<?php if ( $next_link <> "" ) : ?>
		<div class="nav-next"><?php echo $next_link ?></div>
<?php endif; ?>		
	</div><!-- #nav-above -->


	<?php foreach ($pageposts as $post): ?>
	<?php if($blog_id == 1) switch_to_blog($post->blog_id); ?>
	<?php setup_postdata($post); ?>
	
	<?php if ( in_category( 'Gallery' ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

			<div class="entry-meta">
				<?php
					printf( __( '<span class="meta-prep meta-prep-author">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> <span class="meta-sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'twentyten' ),
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date(),
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
						get_the_author()
					);
				?>
			</div><!-- .entry-meta -->

			<div class="entry-content">
				<div class="gallery-thumb">
					<a class="size-thumbnail" href="<?php the_permalink(); ?>"><?php
					$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
					$total_images = count( $images );
					$image = array_shift( $images );
					echo wp_get_attachment_image( $image->ID, 'thumbnail' );
					?></a>
				</div>
				<p><em><?php printf( __( 'This gallery contains <a %1$s>%2$s photos</a>.', 'twentyten' ), 
						'href="' . get_permalink() . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"', 
						$total_images 
					); ?></em></p>

				<?php the_excerpt( '' ); ?>
			</div><!-- .entry-content -->

			<div class="entry-utility">
				<?php
					$category_id = get_cat_ID( 'Gallery' );
					$category_link = get_category_link( $category_id );
				?>
				<a href="<?php echo $category_link; ?>" title="<?php esc_attr_e( 'View posts in the Gallery category', 'twentyten' ); ?>"><?php _e( 'More Galleries', 'twentyten' ); ?></a>
				<span class="meta-sep"> | </span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'twentyten' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ); ?>
			</div><!-- #entry-utility -->
		</div>


	<?php elseif ( in_category( 'asides' ) ) : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( is_archive() || is_search() ) : //Only display Excerpts for archives & search ?>
			<div class="entry-summary">
				<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">				
				<?php the_content( __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="entry-utility">
				<?php
					printf( __( '<span class="meta-prep meta-prep-author">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> <span class="meta-sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'twentyten' ),
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date(),
						get_author_posts_url( get_the_author_meta( 'ID' ) ),
						sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
						get_the_author()
					);
				?>
				<span class="meta-sep"> | </span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'twentyten' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ); ?>
			</div><!-- #entry-utility -->
		</div><!-- #post-<?php the_ID(); ?> -->


	<?php else : ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="post-list-gravatar"><?php 
					printf( __( '%1$s', 'twentyten' ),
						get_avatar(get_profile('ID',get_the_author()),$size='32') 
					);
				?>
			</div>
						
			<div class="entry-meta">
				<?php
					printf( __( '<span class="meta-prep meta-prep-author">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a> <span class="meta-sep"> by </span> <span class="author vcard"><a class="url fn n" href="%4$s" title="%5$s">%6$s</a></span>', 'twentyten' ),
						get_permalink(),
						esc_attr( get_the_time() ),
						get_the_date(),
						get_home_url(),
						sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
						get_the_author()
					);
				?>
			</div><!-- .entry-meta -->
	<?php if ( is_archive() || is_search() ) : //Only display Excerpts for archives & search ?>
			<div class="entry-summary">				
				<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
			</div><!-- .entry-summary -->
	<?php else : ?>
			<div class="entry-content">
				<?php the_excerpt( __( 'Continue&nbsp;reading&nbsp;<span class="meta-nav">&rarr;</span>', 'twentyten' ) ); ?>
				<?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'twentyten' ) . '&after=</div>'); ?>
			</div><!-- .entry-content -->
	<?php endif; ?>

			<div class="entry-utility">
				<span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php echo twentyten_cat_list(); ?></span></span>
				<span class="meta-sep"> | </span>
				<?php $tags_text = twentyten_tag_list(); ?>
				<?php if ( ! empty( $tags_text ) ) : ?>
				<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links"><?php echo $tags_text; ?></span></span>
				<span class="meta-sep"> | </span>
				<?php endif; //$tags_text ?>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'twentyten' ), __( '1 Comment', 'twentyten' ), __( '% Comments', 'twentyten' ) ); ?></span>
				<?php edit_post_link( __( 'Edit', 'twentyten' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ); ?>
			</div><!-- #entry-utility -->
		</div><!-- #post-<?php the_ID(); ?> -->

		<?php comments_template( '', true ); ?>

	<?php endif; // if different categories queried ?>
	<?php restore_current_blog(); ?>
	<?php endforeach; ?>

	<div id="nav-below" class="navigation">
<?php if ( $prev_link <> "" ) : ?>
		<div class="nav-previous"><?php echo $prev_link ?></div>
<?php endif; ?>
<?php if ( $next_link <> "" ) : ?>
		<div class="nav-next"><?php echo $next_link ?></div>
<?php endif; ?>		
	</div><!-- #nav-below -->
