<?php

if ( ! function_exists( 'pr' ) ) {
	/**
	 * Helper function for development.
	 *
	 * @param string $v
	 * @return void
	 * @author Armando Sosa
	 */
	function pr( $v ){
		echo '<pre>';
		print_r( $v );
		echo '</pre>';
	}
}


if ( ! function_exists( 'str_contains' ) ) {
	function str_contains( $pattern, $str ){
		$p = strpos( $str, $pattern );
		return ( false !== $p );
	}
}
if ( ! function_exists( 'str_starts_with' ) ) {
	function str_starts_with( $pattern, $str ){
		$p = strpos( $str,$pattern );
		return ( $p === 0 );
	}
}

if ( ! function_exists( 'thumbgen' ) ) {
	function thumbgen( $src, $w, $h, $zc = 1, $q = 75, $fx = 0 ){
		if ( str_contains( 'gravatar', $src ) ) {
			return $src;
		}

		// check if this is a multisite url,
		// if so, we are going to pass the actual url, not the fake one.
		if ( is_multisite() ) {
			preg_match( '#([_0-9a-zA-Z-]+/)?files/(.+)#', $src, $match );

			if ( isset( $match[2] ) && file_exists( BLOGUPLOADDIR . $match[2] ) ) {
				$absparts = explode( 'wp-content', BLOGUPLOADDIR );

				if ( isset( $absparts[1] ) ) {
					$src = $absparts[1] . $match[2];
				}
			}
		}

		$url  = ONSWIPE_PLUGIN_URL . '/thumb/thumb.php?';
		$url .= "src=$src&w=$w&h=$h&zc=$zc&q=$q&f=$fx";
		$url  = str_replace( '&', '&amp;', $url );
	 	return $url;
	}
}

/**
 * Contrast color
 *
 * @param string $hexcolor
 * @param string $black
 * @param string $white
 * @return void
 * @author Armando Sosa
 */
function best_contrast_color( $hexcolor, $black = 'black', $white = 'white' ){

	$hexcolor = str_replace( '#', '', $hexcolor );

	$r = hexdec( substr( $hexcolor,0,2 ) );
	$g = hexdec( substr( $hexcolor,2,2 ) );
	$b = hexdec( substr( $hexcolor,4,2 ) );

	$yiq = ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000;

	return ( $yiq >= 128 ) ? $black : $white;
}


/**
 * Get layouts from onswipe API
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_get_layouts(){

	$url = 'http://ag.wp.onswipe.com/layouts';

	$onswipe_layouts = get_transient( 'onswipe_layouts' );

	if ( false === $onswipe_layouts ) {
		$onswipe_layouts = array();

		// request the url
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return false;
		} else {
			$json = json_decode( $response['body'] );

			$parts = array( 'toc', 'article' );


			// reformat the array for settings.
			foreach ( $parts as $part ) {
				if ( isset( $json->{$part} ) ){
					$key = $part . '_layout';
					$onswipe_layouts[ $key ] = array();

					foreach( $json->{$part} as $layout ) {
						$onswipe_layouts[ $key ][] = array(
							'value' => $layout->id,
							'name' => $layout->name,
							'image' => $layout->image_horizontal,
							'description' => $layout->description,
						);
					}
				}
			}

			$onswipe_layouts['defaults']['toc_layout']     = $json->defaults->toc;
			$onswipe_layouts['defaults']['article_layout'] = $json->defaults->article;

			// let's cache for five minutes.
			set_transient( 'onswipe_layouts', $onswipe_layouts, 60 * 5 );
		}
	}

	return $onswipe_layouts;


}

/**
 * Returns the correct CDN url for this pub layout.
 *
 * @return void
 * @author Armando Sosa
 */
function layout_assets_url(){
	$layout_generated = get_option( 'onswipe_layout_generated' );
	$cdn_base = 'http://cdn.onswipe.com/wp/reader/publishers/assets/';
	
	if ( empty( $layout_generated ) ) {
		// default layout. for the meantime.
		return $cdn_base . 'pub_default';
	} else {
		$domain   = trailingslashit( get_bloginfo( 'url' ) );
		$cdn_base .= 'pub_';
		$uid      = md5( $domain );
		return $cdn_base . $uid;
	}
}


/**
 * Curate plugins allowed on Onswipe version
 *
 * @param string $list
 * @return void
 * @author Armando Sosa
 */
function onswipe_curator(){
	
	$blacklist = array(
		'loop_end',
		'the_title' => array( 'A2A_SHARE_SAVE_auto_placement' ),
		'the_content' => array( 'outbrain_display', 'convert_smilies', 'A2A_SHARE_SAVE_add_to_content' ),
		'the_excerpt' => array( 'outbrain_display_excerpt' ),
	);
	
	$blacklist = onswipe_get_curator_definitions( $blacklist );
	
	foreach ( $blacklist as $tag => $functions ) {
		if ( ! is_string( $tag ) ) {
			$tag       = $functions;
			$functions = false;
		}

		if ( false === $functions ) {
			remove_all_filters( $tag );
		} else {
			foreach ( (array) $functions as $function_name ) {
				remove_wildcard_filter( $tag, $function_name );
			}
		}
	}
}



/**
 * Get layouts from onswipe API
 *
 * @return void
 * @author Armando Sosa
 */
function onswipe_get_curator_definitions( $default = array() ){

	$url = 'http://cdn.onswipe.com.s3.amazonaws.com/wp/curator/list.txt';
	
	$definitions = get_transient( 'onswipe_curator_list' );

	if ( false === $definitions ) {
		$definitions = array();

		// request the url
		$response = wp_remote_get( $url );

		if ( ! is_wp_error( $response ) ) {
			if ( empty( $response['body'] ) )
				return $default;

			$list = explode( "\n", $response['body'] );

			foreach ( $list as $line ) {
				if ( str_contains( ':', $line ) ) {
					list( $tag, $functions ) = explode( ':', $line );
					$definitions[$tag] = explode( ' ', trim( $functions ) );
				} else {
					$definitions[] = $line;
				}
			}
			
			// let's cache for five minutes.
			set_transient( 'onswipe_layouts', $definitions, 60 * 60 * 2 );
		}
	}
	
	if ( empty( $definitions ) )
		$definitions = $default;

	return $definitions;


}

/**
 * undocumented function
 *
 * @param string $tag
 * @param string $function_name
 * @param string $priority
 * @return void
 * @author Armando Sosa
 */
function remove_wildcard_filter( $tag, $function_name, $priority = 10 ){

	if ( false === str_contains( '*', $function_name ) ) {
		remove_filter( $tag, $function_name );
	} else {
		// make a valid regexp
		$regexp = '/^'.str_replace( '*', '.+', $function_name ).'$/msU';

		// get functions for this filter tag
		if ( isset( $GLOBALS['wp_filter'][$tag][$priority] ) ) {
			// get all function names for this tag
			$function_names = implode( "\n", array_keys( $GLOBALS['wp_filter'][$tag][$priority] ) );

			if ( preg_match_all( $regexp, $function_names, $matches ) ) {
				// if anything matches the regexp, we have functions to remove;
				foreach ( $matches as $match ) {
					if ( isset( $match[0] ) )
						remove_filter( $tag, $match[0] );
				}
			}
		}
	}
}