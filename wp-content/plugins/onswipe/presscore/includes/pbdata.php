<?php

require_once( ONSWIPE_PLUGIN_INCLUDES . '/thumb-helper.php' );


/**
 * Returns an instance of the appropiate PBData Class for $class
 *
 * @package default
 * @author Armando Sosa
 */
function pbdata_factory( $class ){

	$class = 'OnswipePBData' . ucfirst( $class );

	if ( class_exists( $class ) ) {
		return new $class;
	}

	return new WP_Error( 'PBData error', "$class does not exist" );

}


/**
 * Onswipe PBData Class
 *
 * This class manages cachign and json serialization. Just inherit and override the get_data method.
 *
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBData{

	private $data = array();

	public $do_cache = true;

	public $cache_duration = 300;

	function get_cache_key(){

		return $cache_key = md5( get_bloginfo( 'url' ) . get_bloginfo( 'name' ) . '_onswipe_pbdata_' . get_class( $this ) );

	}


	/**
	 * Gets the data and stores a cache.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function _get_data(){

		// a unique cache key for this request
		$cache_key = $this->get_cache_key();

		// five minutes cache. Don't use it for live blogs.
		$cache_life = $this->cache_duration;

		$data = $this->cache_get( $cache_key, $cache_life );

		if ( false === $data ) {
			$this->data = $this->get_data( $this->data );
			$this->cache_set( $cache_key, $this->data );
		} else {
			$this->data = $data;
		}

		return $this->data;

	}

	/**
	 * To be overriden by child classes. Only runs when cache is expired.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function get_data(){

	}

	/**
	 * Outputs the data as JSON
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function print_data(){

		error_reporting( 0 );

		$this->_get_data();

		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Content-type: application/json' );
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: X_REQUESTED_WITH' );

		$this->jsonize();

	}

	/**
	 * A callback function for use in JSONP, or false for no callback.
	 *
	 * @var string
	 */
	public $callback = false;

	/**
	 * Converts the $this->data instance variable into a JSON object. If $this->callback is a string, it will wrapp the data in a JSONP callback
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function jsonize(){

		$data = $this->data;

		$json = json_encode( $data );


		if ( false !== $this->callback ) {
			$json = "{$this->callback}(". $json .');';
		}

		echo $json;

	}

	function reset(){

		$cache_key = $this->get_cache_key();
 		return self::cache_delete( $cache_key );

	}

	/**
	 * Simple presistent cache implementation.
	 *
	 * @param string $key
	 * @param int $expire_time
	 * @return void
	 * @author Armando Sosa
	 */
	private function cache_get( $key ){

		$expire_time = $this->cache_duration;

		// // in development don't use cache.
		if ( defined( 'ONSWIPE_ENV' ) ) {
			return false;
		}

		if ( false === $this->do_cache ) {
			return false;
		}

		$data = false;
		
		if ( PBDATA_USE_TRANSIENTS ) {			
			$data = maybe_unserialize( get_transient( $key ) );
		} else {			
			$filename = PBDATA_CACHE_DIR . '/' . $key . '.txt';

			if ( file_exists( $filename ) ) {
				if ( $expire_time > 0 ) {
					$mtime = filemtime( $filename );
					$diff  = time() - $mtime;

					// the $cache has expired
					if ( $diff > $expire_time )
						return false;
				}

				$rawdata = file_get_contents( $filename );
				$data    = unserialize( $rawdata );
			}
		}

		return $data;
	}

	/**
	 * Simple file-based cache implementation
	 *
	 * @param string $key
	 * @param mixed $rawdata
	 * @return void
	 * @author Armando Sosa
	 */
	private function cache_set( $key, $rawdata ){

		$data = serialize( $rawdata );

		if ( PBDATA_USE_TRANSIENTS ) {
			set_transient( $key, $data, $this->cache_duration );
		} else {
			$filename = PBDATA_CACHE_DIR . '/' . $key . '.txt';
			file_put_contents( $filename, $data );
		}
	}

	/**
	 * removes a cache entry from the PBDATA_CAHE_DIR defined by $key
	 *
	 * @param string $key
	 * @param mixed $rawdata
	 * @return void
	 * @author Armando Sosa
	 */
	private function cache_delete( $key ){
		
		if ( PBDATA_USE_TRANSIENTS ) {
			delete_transient( $key );
		} else {
			$filename = PBDATA_CACHE_DIR . '/' . $key . '.txt';
			if ( file_exists( $filename ) )
				return unlink( $filename );
		}


		return true;

	}


}


/**
 * Generates a 'Publisher' object with the necessary details for the reader layer to work
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBDataPublishers extends OnswipePBData{

	public $callback = 'gotPublishers';

	function get_data( $data ){

		global $Onswipe;

		$options  = $Onswipe->options;
		$blogname = get_bloginfo( 'name' );

		// prevent apostrophes from being doubly encoded
		$blogname = html_entity_decode( $blogname,ENT_QUOTES );

		$publisher_id = get_bloginfo( 'url' );

		$data['publishers'] = array( 
			array(
				'publisher_id'              => $publisher_id,
				'publisher_keyword'         => $blogname,
				'publisher_username'        => str_replace( ' ', '_', strtolower( $blogname ) ),
				'publisher_name'            => $blogname,
				'publisher_icon'            => $options['icon'],
				'publisher_loading'         => $options['loading_screen'],
				'publisher_color'           => $options['accent_color'],
				'publisher_logo'            => $options['logo'],
				'publisher_has_cover'       => '0',
				'publisher_omniture_id'     => '',
				'publisher_custom_domain'   => '',
				'publisher_base_url'        => get_bloginfo( 'name' ),
				'publisher_ad_frequency'    => '0',
				'publisher_hash'            => '',
				'publisher_hpt'             => '0',
				'google_analytics_id'       => $Onswipe->options['google_analytics'],
			),
		);


		$data['sources'] = array();
		$data['designs'] = array(
			array(
				'design_id'         => '255',
				'publisher_id'      => $publisher_id,
				'design_name'       => 'silk',
				'design_cover'      => $options['article_layout'],
				'design_category'   => $options['toc_layout'],
				'design_article'    => $options['article_layout'],
				'design_style'      => '10',
				'design_font_h1'    => $options['font'],
				'design_font_body'  => "'Helvetica'",
			),
		);

		return $data;

	}

}


/**
 * Generates an object with the categories and 100 last entries formatted for the reader layer.
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBDataEntries extends OnswipePBData{

	public $callback = 'gotEntries';

	public $cache_duration = 43200;

	function get_data( $data ){

		$data['categories'] = $this->get_categories();
		$data['entries']    = $this->get_entries();

		return $data;

	}


	function get_categories(){

		// get top level categories only.
		$args = array(
			'type'          => 'post',
			'orderby'       => 'term_group',
			'hide_empty'    => 0,
			'hierarchical'  => 0,
			'parent'        => 0,
		);

		$__categories = get_categories( $args );
		$categories   = array();

		foreach ( $__categories as $__cat ) {
			$categories[] = array(
				'category_id' => (string) $__cat->term_id,
				'category_name' => (string) $__cat->name,
				'category_slug' => (string) $__cat->slug,
			);
		}

		return $categories;

	}

	function get_options(){

		$options = array(
			'posts_per_page' => 75,
			'post_status' => 'publish',
		);

		return $options;
	}

	function get_entries(){

			onswipe_curator();

			add_filter( 'the_content', array( $this, 'strip_tags' ) );
			add_filter( 'the_content', array( $this, 'append_featured_image' ) );

			$entries = array();

			// query parameters
			$options = $this->get_options();

			// query for the posts
			query_posts( $options );

			// loop trough the posts and propagate the entries array
			if ( have_posts() ) while ( have_posts() ){
				the_post();

				// this is a hack to get full posts always
				global $more, $post, $pages;
				$more = true;

				// disable multiple pages support
				$pages = (array)implode( "\n", $pages );

				// let's cache some important values
				$content         = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );
				$date            = get_the_date( 'Y/m/d' );
				$category_ids    = wp_get_post_categories( $post->ID );
				$category_names  = wp_get_post_categories( $post->ID, array( 'fields' => 'names' ) );
				$post_format     = 'article';

				// let's populate the object;
				$entry = array(
					'entry_id'           => (string) $post->ID,
					'source_id'          => '0',
					'publisher_id'       => '0',
					'entry_url'          => get_permalink(),
					'entry_kind'         => $post_format,
					'entry_author'       => html_entity_decode( get_the_author(), ENT_QUOTES ),
					'entry_title'        => str_replace( '&nbsp;', ' ', get_the_title() ), // sorry, but when titles are narrow we DO want widows.
					'entry_excerpt'      => get_the_excerpt(),
					'entry_content'      => $content,
					'published_at'       => strtotime( get_the_time() ),
					'entry_updated'      => $date,
					'entry_created'      => $date,
					'source_name'        => 'wordpress.com',
					'category_ids'       => $category_ids,
					'category_names'     => $category_names,
					'category_assoc'     => array(),
					'entry_comments_url' => get_bloginfo( 'url' ) . '?comments_popup=' . $post->ID,
					'score'              => '42',
					'entry_media'        => ThumbHelper::post_media_objects(
					    array( 'featured_image', 600, 800 ),
					    array( 'featured_image_thumbnail', 300, 400 )
					),
				);

				$entries[] = $entry;

			}

			return $entries;

	}

	/**
	 * This filter adds the featured image to the top of the post if there's no image embeded and there's a featured image.
	 *
	 * @package default
	 * @author Armando Sosa
	 */

	public function append_featured_image( $content, $class = 'entry-image' ){

		$has_image = ThumbHelper::has_embedded_image( $content );

		if ( ! $has_image ) {
			$image = ThumbHelper::get_featured_image( 'medium' );

			if ( false !== $image ) {
				$content = "<img src='{$image[0]}' class='$class' /> \n" . $content;
			}
		}

		return $content;
	}
	
	/**
	 * Strip Tags
	 *
	 * @param string $content 
	 * @return void
	 * @author Armando Sosa
	 */
	public	function strip_tags( $content ){

		error_reporting( E_ALL );

		if ( empty( $content ) )
			return $content;
		
		$content = strip_tags( $content, '<p><img><a><iframe><ul><ol><li><em><strong><b><i><dl><dt><dd><object>' );
		
		return $content;
	}



}

/**
 * Generates a single entry object for the reader layer.
 * This is not a JSONP callback.
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBDataEntry extends OnswipePBDataEntries{

	public $callback = false;

	public $id;

	function __construct(){

		if ( isset( $_GET['eid'] ) ) {
			$this->id = (int) esc_attr( $_GET['eid'] );
		}

	}

	function get_cache_key(){
		return $cache_key = md5( get_bloginfo( 'url' ) . get_bloginfo( 'name' ) . '_onswipe_pbdata_' . get_class( $this ) . $this->id );
	}

	function get_categories(){


		$categories = array();

		$category_ids = implode( ',', wp_get_post_categories( $this->id ) );

		$__categories = get_categories( array( 'include' => $category_ids ) );

		foreach ( $__categories as $__cat ) {
			$categories[] = array(
				'category_id'       => (string) $__cat->term_id,
				'category_name'     => (string) $__cat->name,
				'category_slug'     => (string) $__cat->slug,
			);
		}

		return $categories;

	}

	function get_options(){

		$post = get_post( $this->id );

		if ( 'post' === $post->post_type ) {
			$options = array(
				'p' => $this->id,
				'post_status' => 'publish',
			);
		} else {
			$options = array(
				'page_id' => $this->id,
				'post_status' => 'publish',
			);
		}

		return $options;
	}


}


/**
 * Generates an object with the categories and 100 last entries formatted for the reader layer.
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBDataRecommendations extends OnswipePBData{

	// no JSONP
	public $callback = false;

	public $do_cache = false;


	function get_data( $data ){

		$data['articles'] = $this->get_entries();

		return $data;

	}


	function get_options(){

		$options = array(
			'posts_per_page' => 5,
			'post_status' => 'publish',
			'orderby' => 'rand',
		);

		return $options;

	}

	function get_entries(){

		onswipe_curator();

		$entries = array();

		// query parameters
		$options = $this->get_options();

		// query for the posts
		query_posts( $options );

		// loop trough the posts and propagate the entries array
		if ( have_posts() ) while ( have_posts() ){
			the_post();

			// this is a hack to get full posts always
			global $more, $post, $pages;
			$more = true;

			// disable multiple pages support
			$pages = (array)implode( "\n", $pages );

			// let's cache some important values
			$content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );

			// let's populate the object;
			$entry = array(
				'entry_id'          => (string) $post->ID,
				'id'                => (string) $post->ID,
				'publisher_id'      => '0',
				'link'              => get_permalink(),
				'title'             => str_replace( '&nbsp;', ' ', get_the_title() ), // sorry, but when titles are narrow we DO want widows.
				'excerpt'           => get_the_excerpt(),
				'description'       => $content,
				'timestamp'         => get_the_date( 'Y/m/d h:i:s T' ),
			);

			$entries[] = $entry;
		}

		return $entries;

	}


}

/**
 * Displays the data for the assetgen service.
 * This is not a JSONP callback.
 *
 * @package default
 * @author Armando Sosa
 */
class OnswipePBDataInfo extends OnswipePBData{

	public $callback = false;

	public $do_cache = false;

	function get_data(){

		global $Onswipe;

		$options = get_option( 'onswipe_options' );

		$info = array(
			'v' => $Onswipe->version,
			'toc' => (int) $options['toc_layout'],
			'article' => (int) $options['article_layout'],
			'accent_color' => $options['accent_color'],
		);

		return $info;
	}


}
