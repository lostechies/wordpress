<?php 
/*
Plugin Name: Pygment Embedder
Plugin URI: http://jeremiahsturgill.com
Description: Replaces code with prettified HTML & CSS.  Usage: [code language="php"]code here[/code]
Version: 1.0
Author: J. Sturgill Designs
Author URI: http://jeremiahsturgill.com
*/

include( 'config.php' );

include( 'functions.php' );

add_filter( 'no_texturize_shortcodes', 'exclude_code' );
add_shortcode( PYGMENT_SHORTCODE_NAME, 'prettify_code' );
add_action( 'wp_enqueue_scripts', 'add_pygment_stylesheet' );