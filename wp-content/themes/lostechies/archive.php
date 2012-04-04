<?php get_header(); ?>


		<div id="content">
			<div id="main" class="grid_8">
			<?php the_post(); ?>

			<?php if ( is_day() ) : ?>
							<h1 class="page-title"><?php printf( __( 'Daily Archives: <span>%s</span>', 'twentyten' ), get_the_date() ); ?></h1>
			<?php elseif ( is_month() ) : ?>
							<h1 class="page-title"><?php printf( __( 'Monthly Archives: <span>%s</span>', 'twentyten' ), get_the_date('F Y') ); ?></h1>
			<?php elseif ( is_year() ) : ?>
							<h1 class="page-title"><?php printf( __( 'Yearly Archives: <span>%s</span>', 'twentyten' ), get_the_date('Y') ); ?></h1>
			<?php else : ?>
							<h1 class="page-title"><?php _e( 'Blog Archives', 'twentyten' ); ?></h1>
			<?php endif; ?>

			<?php rewind_posts(); ?>

			<?php get_template_part( 'loop', 'archive' ); ?>

			</div>
			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!-- #container -->
		</div><!-- #content -->

<?php get_footer(); ?>
