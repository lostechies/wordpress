<?php
/*
Plugin Name: WP-Note
Plugin URI: http://geeklu.com/2009/01/wp-note
Description: Make nice notes with WP-Note in your post.
Version: 1.2
Author: Luke
Author URI: http://geeklu.com
*/

add_action( 'wp_enqueue_scripts', 'wp_note' );
add_filter('the_content', 'render_notes', 10);
add_filter('the_excerpt', 'render_notes', 10);
register_activation_hook(__FILE__,'active_wp_note');
register_deactivation_hook(__FILE__,'deactive_wp_note');

function wp_note(){
	$wp_note = get_option('wp_note');
	#if($wp_note=='1'){
     	wp_register_style( 'prefix-style', plugins_url('style.css', __FILE__) );
     	wp_enqueue_style( 'prefix-style' );
	#}
}

function render_notes($text) {
	wp_enqueue_style('wpnotecss', plugins_url('/wp-note.css',__FILE__) );
	$note_tag_elements = array(
	'\[note\s*\]' => '<div class="note">',
	'\[/note\]' => '</div>',
	'\[important\s*\]' => '<div class="note-important">',
	'\[/important\]' => '</div>',
	'\[warning\s*\]' => '<div class="note-warning">',
	'\[/warning\]' => '</div>',
	'\[tip\s*\]' => '<div class="note-tip">',
	'\[/tip\]' => '</div>',
	'\[help\s*\]' => '<div class="note-help">',
	'\[/help\]' => '</div>'
	);

	foreach ($note_tag_elements as $notetag => $showtag) {
		$text = eregi_replace($notetag, $showtag, $text);
	}
	return $text;
}

function active_wp_note(){
	add_option('wp_note','1','active the plugin');
}

function deactive_wp_note(){
	delete_option('wp_note');
}

?>
