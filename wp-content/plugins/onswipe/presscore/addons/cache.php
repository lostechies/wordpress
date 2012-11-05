<?php

add_action( 'wp_head', 'escape_from_cache' );

function escape_from_cache(){
	global $Onswipe;
	if ($Onswipe->options['enabled'] !== "enabled")
		return;
	if ( defined( 'W3TC' ) || defined( 'WPCACHEHOME' )) {
?>
	<script type="text/javascript" charset="utf-8">
		// redirect cached page
		 if( navigator.userAgent.toLowerCase().match( /ipad/ ) ){
			location.href  = location.href + "?onswipe_redirect=yes";
		}
	</script>
<?php
	}
	
}