<?php get_header(); ?>

<div id="content">
			<div id="main" class="grid_8">
			
				<?php the_post(); ?>
				<div id="post-<?php the_ID(); ?>" >
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-content">
						<?php the_content(); ?>
						<?php wp_link_pages( 'before=<div class="page-link">' . __( 'Pages:', 'twentyten' ) . '&after=</div>' ); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-content -->
				</div><!-- #post-<?php the_ID(); ?> -->
				<a name="respond"></a>
				<?php comments_template( '', true ); ?>
			</div><!-- #main -->
			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!--sidebar-->
		</div><!-- #content -->
		
<?php get_footer(); ?>
