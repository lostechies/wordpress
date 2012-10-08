<?php
/*
Plugin Name: Onswipe
Plugin URI: http://onswipe.com/setup
Description: Provide a beautiful app like experience for your readers when they visit your blog from their tablet web browser.  Onswipe is fully customizable by offering thousands of layout combinations and the ability to add your blog's branding. Get started in under 3 minutes for free.  Onswipe for Wordpress is a whole new platform for the ground-up using the same features available to publishers like Slate.com, Geek.com, and Wired.
Version: 2.1.5
Author: Onswipe <founders@onswipe.com>
Author URI: http://onswipe.com/
*/

/**
 * Copyright (c) 2012 Onswipe. All rights reserved.
 *
 */

#MERGE dotcom.php
if ( file_exists( dirname( __FILE__ ) . '/dotcom.php' ) ) {
	// include dirname( __FILE__ ) . '/dotcom.php';
}
#/MERGE

// Include PressCore 
include dirname( __FILE__ ) . '/presscore/presscore.php';

// Register Activation/Deactivation hooks
register_activation_hook( __FILE__, array( 'PressCore', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'PressCore', 'deactivate' ) );

// Start the plugin execution
function init_onswipe() {
	global $Onswipe;
	$Onswipe->start();
}
add_action( 'plugins_loaded', 'init_onswipe' );



