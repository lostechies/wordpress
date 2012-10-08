<?php

class ThumbHelper {

	static $local;

	static $stop_looking = false;

	/**
	 * Whether it has a thumbnail image or not.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function has_thumb(){
		global $id;
		if ( has_post_thumbnail() ) {
			return true;
		} else {
			$image = self::legacy_post_image( $id );
			return !empty( $image );
		}
	}

	/**
	 * gets the post's image thumbnail ad displays it using tim thumb
	 *
	 * @param string $w
	 * @param string $h
	 * @param string $link
	 * @return void
	 * @author Armando Sosa
	 */
	function post_image( $w = 280, $h = 180 ) {

		global $post, $id;

		self::$stop_looking = false;

		$cached = self::get_cached_image();
		// got a cached image. return that.
		if ( ! empty( $cached ) )
			return $cached;
		// got nothing, but that's ok.
		if ( self::$stop_looking )
			return false;

		// keep looking.

		$image = self::get_featured_image();

		// no post image found. Let's try to find one by brute force.
		if ( false === $image ) {
			if ( empty( $image ) ) {
				$image = self::legacy_post_image( $id );
			}
		} else {
			$image = $image[0];
		}

		if ( self::is_local( $image ) ) {
			if ( false !== $w && false !== $h ){
				$image = thumbgen( $image, $w, $h );
			}
		}

		self::set_cached_image( $image );

		return $image;


	}

	function get_cached_image(){
		global $post;

		$meta = get_post_meta( $post->ID, 'onswipe_thumb', true );

		if ( 'SKIP' == $meta ) {
			// stop looking for images.
			self::$stop_looking = true;
			return false;
		}

		return $meta;


	}

	function set_cached_image( $image ){

		global $post;

		if ( empty( $image ) )
			$image = 'SKIP';

		add_post_meta( $post->ID, 'onswipe_thumb', $image, true );

	}

	function get_featured_image( $size = 'regular' ){

		global $id;

		$post_thumbnail_id = get_post_thumbnail_id( $id );
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $size );

		return $image;
	}

	/**
	 * checks if this is an external or local image we are dealing with.
	 *
	 * @param string $image
	 * @return void
	 * @author Armando Sosa
	 */
	function is_local( $image ){

		error_reporting( E_ALL );
		// cache url
		if ( ! self::$local ) 
			self::$local = '#^' . addslashes( get_bloginfo( 'url' ) ) . '#';

		return preg_match( self::$local, $image );

	}


	/**
	 * return an array of media objects suited for pbdata
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function post_media_objects(){

		$formats = func_get_args();

		$objects = array();

		foreach ( $formats as $format ) {
			list( $name, $w, $h ) = $format;
			$object = self::post_media_object( $w, $h );
			if ( false !== $object ) {
				$objects[$name] = $object;
			}
		}

		return $objects;
	}

	/**
	 * returns a media object suited for pbdata
	 *
	 * @param string $w
	 * @param string $h
	 * @return void
	 * @author Armando Sosa
	 */
	function post_media_object( $w, $h ){

		$src = self::post_image( $w, $h, true );

		if ( false !== $src ) {
			return array(
				'src'    => $src,
				'width'  => $w,
				'height' => $h,
			);
		}

		return array(
			'src'    => null,
			'width'  => null,
			'height' => null,
		);


	}

	/**
	 * Does its best to return a thumbnail image when no native thumb
	 * has been defined.
	 *
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function legacy_post_image( $id ) {

		$methods = array(
			'get_from_custom_field',
			'find_video_thumb',
			'get_first_attachment',
			'find_image_in_body',
		);

		foreach ( $methods as $method ) {
			// we should stop here!
			if ( self::$stop_looking )
				return false;

			$image = self::$method( $id );
			if ( ! empty( $image ) ) {
				return $image;
			}
		}

		return false;
	}

	/**
	 * this is in case the user is not using WP's native post image.
	 *
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function get_from_custom_field( $id ) {

		$key_match   = '/image/';
		$meta_values = get_post_custom( $id );

		foreach ( $meta_values as $key => $value ) {
			if ( preg_match( $key_match, $key ) ) {
				if ( is_array( $value ) )
					$value = $value[0];

				if ( ! empty( $value ) )
					return $value;
			}
		}

		return false;
	}

	/**
	 * tries to return the first attached image.
	 *
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function get_first_attachment( $id ) {
		$attachments = get_children(
		    array(
		        'post_parent'    => $id,
		        'numberposts'    => 1,
		        'post_type'      => 'attachment',
		        'post_mime_type' => 'image',
		        'order'          => 'DESC',
		        'orderby'        => 'menu_order date',
		    )
		);
		if ( ! empty( $attachments ) ) {
			// Search for and get the post attachment
			foreach ( $attachments as $attachment ) {
				$image = $attachment->guid;
			}

			if ( ! empty( $image ) )
				return $image;
		}

		return false;
	}

	/**
	 * searches for a youtube url in the post and returns its thumb
	 *
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function find_video_thumb( $id ){

		$image   = false;
		$content = get_the_content( '' );

		// this will match plain youtube urls, which will be later catched by oembed
		$regexp = '#youtube.com\/watch.+v=([^&]+)#'; // matches the old url structure
		if ( preg_match( $regexp, $content, $matches ) ){
			$image = "http://img.youtube.com/vi/{$matches[1]}/0.jpg";
		}

		$regexp = '#youtube.com\/v\/([^?|^&]+)#'; // matches the old url structure
		if ( preg_match( $regexp, $content, $matches ) ){
			$image = "http://img.youtube.com/vi/{$matches[1]}/0.jpg";
		}


		return $image;
	}

	/**
	 * Find images in the post body and tries to find the best one (based on source) to use as thumbnail.
	 * Then it 'caches' it in a custom field so this only runs once.
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function find_image_in_body( $id ){
		$image = false;

		remove_filter( 'the_content', 'convert_smilies' );	// we don't want to return smileys so we disable them
		$content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );

		if ( false === self::has_embedded_image( $content ) ) {
			self::$stop_looking = true;
			return false;
		}


		$regexp = '#<\s*img [^\>]*src\s*=\s*(["|\'])(.*?)\1[^\>]*#im';

		preg_match_all( $regexp, $content, $matches );

		unset( $regexp );
		unset( $content );

		if ( isset( $matches[2] ) && ! empty( $matches[2] ) ) {
			$image = self::get_best_image( $matches[2] );
		}

		return $image;
	}

	/**
	 * Does its best to find the better possible image
	 *
	 * @param string $images
	 * @return void
	 * @author Armando Sosa
	 */
	function get_best_image( $images ){

		$count     = 5; // will just iterate over the first n images
		$better    = array();
		$blacklist = '/' . implode( '|', array( '\.gif', '\.ico', 'twimg', 'transparent', 'sociable\/', 'viewad', 'banner' ) ) . '/';

		foreach ( $images as $image ) {
			if ( $count == 0 ) 
				break;
				
			if ( ! preg_match( $blacklist, $image ) )
				$better[] = $image;

			$count--;
		}

		if ( ! empty( $better ) ) {
			$best = $better[0];
		} else {
			$best = $images[0];
		}


		return $best;


	}

	/**
	 * Does this text have any images in it?
	 *
	 * @param string $content
	 * @return void
	 * @author Armando Sosa
	 */
	function has_embedded_image( $content = false ){

		if ( false === $content ){
			$content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );
		}

		$regexp = '#<\s*img [^\>]*src\s*=\s*(["|\'])(.*?)\1[^\>]*#im';
		preg_match( $regexp, $content, $matches );

		unset( $regexp );
		unset( $content );

		if ( empty( $matches ) ) {
			return false;
		}

		return true;
	}


}
