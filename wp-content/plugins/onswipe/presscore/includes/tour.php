<?php

add_action( 'admin_enqueue_scripts', 'onswipe_tour_enqueue' );	

function onswipe_tour_enqueue(){
	wp_enqueue_style( 'wp-pointer' );
	wp_enqueue_script( 'wp-pointer' );
	add_action( 'admin_print_footer_scripts', 'onswipe_tour' );
}

function onswipe_tour(){

	$pointer = "onswipe21_check_admin";
	$dismissed = array_filter( explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) ) );

	// Pointer has been dismissed
	if ( in_array( $pointer, $dismissed ) )
		return;

	$pointer_content  = '<h3>' . __('Thanks for installing Onswipe') . '</h3>';
	$pointer_content .= '<p>' . __('This is our settings page. Go here to customize your design') . '</p>';
?>
	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {

		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		
		$('#toplevel_page_Onswipe').pointer({
			content: '<?php echo $pointer_content; ?>',
			position: 'top',
			close: function() {
				$.post( ajaxurl, {
					pointer: '<?php echo $pointer; ?>',
					action: 'dismiss-wp-pointer'
				});
			}
	    }).pointer('open');
	});
	//]]>
	</script>
<?php
}