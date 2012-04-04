<script type="text/javascript" charset="utf-8">

	<?php
	if ( is_user_logged_in() )
		echo 'App.wpShare = ' . json_encode( 'http://wordpress.com/quickpress/?reblog=' . get_current_blog_id() ) . PHP_EOL;
	?>
	App.blogName = <?php echo json_encode( get_bloginfo('name') ); ?>;
	App.baseUrl = <?php echo json_encode( trailingslashit( get_bloginfo('url') ) ); ?>;
	App.assetsUrl = <?php echo json_encode( PADPRESS_PLUGIN_URL . '/themes/warp/assets/' ); ?>;

	<?php if (is_category()): ?>
	App.currentTermType = "category";
	App.currentTermId = <?php echo $cat = get_query_var('cat'); ?>;
	<?php $category = get_category($cat) ?>
	App.currentTermSlug = <?php echo json_encode( $category->slug ); ?>;
	App.currentTermTitle = '<?php echo json_encode( $category->name ); ?>';	
	<?php endif ?>	

	
</script>
