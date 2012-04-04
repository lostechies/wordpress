<?php get_header(); ?>

			<div id="content">
			<div id="main" class="grid_8">

				<h1 class="page-title"><?php 
					printf( __( 'Category Archives: %s', 'twentyten' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h1>
				<?php $categorydesc = category_description(); if ( ! empty( $categorydesc ) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

<?php get_template_part( 'loop', 'category' ); ?>
	</div>
			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!-- #container -->
		</div><!-- #content -->
<?php get_footer(); ?>
