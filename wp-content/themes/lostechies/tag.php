<?php get_header(); ?>

	
		<div id="content">
			<div id="main" class="grid_8">
<?php the_post(); ?>

				<h1 class="page-title"><?php 
					printf( __( 'Tag Archives: %s', 'twentyten' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					
				?></h1>

<?php rewind_posts(); ?>

<?php get_template_part( 'loop', 'tag' ); ?>
			</div>
			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!-- #container -->
		</div><!-- #content -->
<?php get_footer(); ?>
