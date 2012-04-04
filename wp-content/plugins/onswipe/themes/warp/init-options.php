<?php

// only run this file when needed.
$ourpanel = (is_admin() && $_GET['page'] == "padpressed");
$ajax = defined('DOING_AJAX');
$in_options_page = str_contains("options.php",__FILE__);


if (!($this->isMobileAndSupported() || $ourpanel || $ajax || $in_options_page)) return;
	
define('PADPRESS_THEME_DIR', dirname(__FILE__));

global $Options;

// Options panel settings
$panel_settings = array(
	'name'=>'padpress_warp',
	'menu_title'=>'Theme Options',
	'top_level'=>'padpressed',
	'file_path'=>PADPRESS_THEME_DIR."/views/panels/options-panel.php",
	'custom_css'=>$this->asset('panels.css','css'),
	'custom_js'=>$this->asset('panels.js','js'),
	'auto_register'=>false,
);


$default_options = array(
	'cover_logo'=>'',
	'launch_screen'=>'',
	'skin'=>false,
	'slideshow_category_id'=>0,
	'slideshow_autoplay'=>0,
	'credits' => '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . ' <hr> Theme: <a href="http://padpressed.com" target="_blank">Warp</a> <a href="http://wordpress.com/" title="' . __( 'Semantic Personal Publishing Platform', 'padpressed' ) . '" rel="generator">' . sprintf( __( 'Proudly powered by %s.', 'padpressed' ), 'WordPress' ) . '</a>',
	'show_cover'=>1,
	'color_skin'=>'default',
);

// init the panel with the default options
$Options->addPanel($panel_settings,$default_options);
