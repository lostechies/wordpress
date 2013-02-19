<?php
include ( 'class.php' );

function prettify_code( $attributes, $content='' )
{
  $content = str_replace( '&#038;', '&', $content ); // already encoded by WP
	pygmenter::$code_count++;
	$cache_var = PYGMENT_CACHE_VAR . '_' . pygmenter::$code_count;
	$cache_hash_var = PYGMENT_CACHE_HASH_VAR . '_' . pygmenter::$code_count;
	global $post;
	$defaults = array(
			PYGMENT_LANGUAGE_ATTRIBUTE => 'php+html',
	);
	extract( shortcode_atts( $defaults, $attributes ) );

	$hash = hash( PYGMENT_HASH, $content . $language );
	$cache = get_post_meta( $post->ID, $cache_var, $single = TRUE );
	$cache_hash = get_post_meta( $post->ID, $cache_hash_var, $single = TRUE );
	if ( $cache_hash != $hash )
	{
		$cache = pygmenter::get_pygment( $content, $language );
		update_post_meta( $post->ID, $cache_var, $cache );
		update_post_meta( $post->ID, $cache_hash_var, $hash );
		if ( DISPLAY_WEBSERVICE_NOTICE === TRUE )
		{
			$cache .= '<p style="font-size:small;">Pygmented code retrieved from webservice.</p>';
		}
	}
	return $cache;
}

function exclude_code( $excluded_shortcodes ) {
	$excluded_shortcodes[] = PYGMENT_SHORTCODE_NAME;

	// While we're at it, remove autop and replace it with a lower priority
	// so that it runs after shortcodes.
	remove_filter( 'the_content', 'wpautop' );
	add_filter( 'the_content', 'wpautop' , 12 );
	return $excluded_shortcodes;
}

function add_pygment_stylesheet() {

	wp_register_style( PYGMENT_STYLE_NAME, plugins_url('css/' . PYGMENT_THEME . '.css', __FILE__) );
	wp_enqueue_style( PYGMENT_STYLE_NAME );
}