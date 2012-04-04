<?php get_header(); ?>

		<div id="content">
			<div id="main" class="grid_8">
			<?php if(function_exists('wp_greet_box')){wp_greet_box();} ?>
			<?php get_template_part( 'loop', 'index' ); ?>
			</div><!-- #main -->
			<div id="sidebar" class="grid_4">
				<?php get_sidebar(); ?>
			</div><!--sidebar-->
		</div><!-- #content -->
	
<?php get_footer(); ?>
