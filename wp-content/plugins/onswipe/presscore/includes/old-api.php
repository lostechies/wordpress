<?php
/**
 * Support for the old API.
 *
 * @package default
 * @author Armando Sosa
 */
class RESTAPI{

	private $__request;
	private $__action;
	private $__method;
	private $__callback;
	private $__params;
	private $__named = false;
	private $routes;

	/**
	 * Constructor
	 *
	 * @author Armando Sosa
	 */
	function __construct(){
		$hook = 'rest_api_request';
		add_action( "wp_ajax_nopriv_$hook", array( $this,'handle_request' ) );
		add_action( "wp_ajax_$hook", array( $this, 'handle_request' ) );
	}

	function get( $route,$callback ){
		$this->route( 'get', $route, $callback );
	}

	function post( $route, $callback ){
		$this->route( 'post', $route, $callback );
	}

	function put( $route, $callback ){
		$this->route( 'put', $route, $callback );
	}

	function delete( $route, $callback ){
		$this->route( 'delete', $route, $callback );
	}


	function route( $method, $route, $callback ){
		$method = strtoupper( $method );
		$this->routes[$method][$route] = $callback;
	}


	function handle_request(){
		$this->__parse_request();
		if ( is_callable( $this->__callback ) ) {

			if ( $this->__named ) {
				call_user_func( $this->__callback, $this->__params );
			}else{
				call_user_func_array( $this->__callback, $this->__params );
			}
		}else{
			echo '404';
		}
		die;
	}

	private function __parse_request(){
		$raw_request = $_REQUEST;
		$this->__query = array_splice( $raw_request, 2 );
		$this->__method = $_SERVER['REQUEST_METHOD'];
		$this->__request = preg_replace( "#\/$#", '', $raw_request['api_request'] ); // I'm trimming the trailing slash
		$this->__params = explode( '/', $this->__request );
		$this->__action = array_shift( $this->__params );

		$this->__router( $this->__request );


	}

	/**
	 * Very simple router
	 *
	 * @param string $uri
	 * @return void
	 * @author Armando Sosa
	 */
	private function __router( $uri ){

		if ( ! isset( $this->routes[$this->__method] ) ) return;

	    foreach ( $this->routes[$this->__method] as $route => $callback ) {

			// first, check for catch-all asterisks
			$reRule = preg_replace( '/\*/', '(.+)$', $route, -1, $asterisks );

			// then, for named parameters
			$reRule = preg_replace( '/:([a-z]+)/', '(?P<\1>[^/]+)', $reRule, -1, $named );
			$reRule = str_replace( '/', '\/', $reRule );

			//execute the regexp
			preg_match( '/' . $reRule . '/', $uri, $matches );

			if ( $matches ) {
				$this->__callback = $callback;
				if ( $asterisks ) {
					$this->__params = explode( '/', $matches[1] );
				}else{
					$this->__named = true;
					$this->__params = array();
					foreach ( $matches as $k => &$v ) {
						if ( ! is_int( $k ) ) {
							$this->__params[$k] = $v;
						};
					}
				}
				break;
			}

		}
	}

	/**
	 * Converts an object or array to JSON and outputs it
	 *
	 * @param string $object
	 * @return void
	 * @author Armando Sosa
	 */
	function jsonize( $object ){
        header( 'Cache-Control: no-cache, must-revalidate' );
        header( 'Content-type: application/json' );
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: X_REQUESTED_WITH' );
		echo json_encode( $object );
		die;
	}


}


global $api;

$api = new RESTAPI;
$api->get( 'categories','api_get_categories' );
$api->get( 'posts/*', 'api_get_posts' );
$api->get( 'post/*', 'api_get_post' );


/**
 * Api method for retrieving categories
 *
 * @param string $params
 * @return void
 * @author Armando Sosa
 */
function api_get_categories( $params ){
	global $api;
	$cats = get_categories();
	$api->jsonize( array( 'categories' => $cats ) );
}


/**
 * Api method for retrieving posts
 *
 * @param string $page
 * @param string $posts_per_page
 * @return void
 * @author Armando Sosa
 */
function api_get_posts( $page = 1, $posts_per_page = 0 ){

	global $api;

	$posts = array();

	// query parameters
	$options = array(
		'post_status'=>'publish',
		'paged'=> $page
	);

	if ( $posts_per_page > 0 ) {
		$options['posts_per_page'] = $posts_per_page;
	}

	// query for the posts
	query_posts( $options );
	global $wp_query;

	$max_pages = $wp_query->max_num_pages;

	// this is the meta information that we'll pass to the app
	$object['meta']	= array(
		'max_pages'=> $max_pages,
		'current_page'=>absint( get_query_var( 'paged' ) )
	);

	// loop trough the posts and propagate the object array
	if ( have_posts() ) while ( have_posts() ){

		the_post();

		// this is a hack to get full posts always
		global $more, $post;
		$more = true;

		// this is to get the content with all the filters without echoing it.
		$content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );


		// populate the object;
		$postObject = array(
			'id'=>$post->ID,
			'author_id'=>$post->post_author,
			'author_display_name'=>get_the_author(),
			'title'=>get_the_title(),
			'post_date'=>$post->post_date,
			'permalink'=>get_permalink(),
			'content'=>$content,
			'excerpt'=>get_the_excerpt(),
			'featured_image'=>PostsHelper::getImage(),
			'comments_open'=>comments_open( $post->ID ),
			'comment_count'=>get_comments_number(),
			'shortlink'=>'',
			'categories'=>get_the_category()
		);

		// if a shortlink exists, let's use that.
		if ( function_exists( 'wp_get_shortlink' ) ) {
			$postObject['shortlink'] = wp_get_shortlink( $post->ID, 'post' );
		}else {
			$postObject['shortlink'] = $postObject['permalink'];
		}

		$object['posts'][] = $postObject;
	}

	$api->jsonize( $object );

}/**
 * Api method for retrieving posts
 *
 * @param string $page
 * @param string $posts_per_page
 * @return void
 * @author Armando Sosa
 */

function api_get_post( $id ){

	global $api;

	$posts = array();

	// query parameters
	$options = array(
		'post_status'=>'publish',
		'p'=> $id
	);

	if ( $posts_per_page > 0 ) {
		$options['posts_per_page'] = $posts_per_page;
	}

	// query for the posts
	query_posts( $options );
	global $wp_query;

	$max_pages = $wp_query->max_num_pages;

	// this is the meta information that we'll pass to the app
	$object['meta']	= array(
		'max_pages'=> $max_pages,
		'current_page'=>absint( get_query_var( 'paged' ) )
	);

	// loop trough the posts and propagate the object array
	if ( have_posts() ) while ( have_posts() ){
		the_post();

		// this is a hack to get full posts always
		global $more, $post;
		$more = true;

		// this is to get the content with all the filters without echoing it.
		$content = str_replace(']]>', ']]&gt;', apply_filters( 'the_content', get_the_content( '' ) ) );


		// populate the object;
		$postObject = array(
			'id'=>$post->ID,
			'author_id'=>$post->post_author,
			'author_display_name'=>get_the_author(),
			'title'=>get_the_title(),
			'post_date'=>$post->post_date,
			'permalink'=>get_permalink(),
			'content'=>$content,
			'excerpt'=>get_the_excerpt(),
			'featured_image'=>PostsHelper::getImage(),
			'comments_open'=>comments_open( $post->ID ),
			'comment_count'=>get_comments_number(),
			'shortlink'=>'',
			'categories'=>get_the_category()
		);

		// if a shortlink exists, let's use that.
		if ( function_exists( 'wp_get_shortlink' ) ) {
			$postObject['shortlink'] = wp_get_shortlink( $post->ID, 'post' );
		}else {
			$postObject['shortlink'] = $postObject['permalink'];
		}

		$object['posts'][] = $postObject;
	}

	$api->jsonize( $object );

}


class PostsHelper{


	/**
	 * gets the post's image thumbnail ad displays it using tim thumb
	 *
	 * @param string $w
	 * @param string $h
	 * @param string $link
	 * @return void
	 * @author Armando Sosa
	 */
	function getImage(){

		global $post, $id;

		$post_id = $id;
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $size='regular' );

		if ( ! $image ) {
			$image = self::legacyPostImage( $id );
			if ( false === $image ) return false;
		}else{
			$image = $image[0];
		}

		return $image;

	}

	/**
	 * Does its best to return a thumbnail image when no native thumb
	 * has been defined.
	 *
	 * @param string $id
	 * @return void
	 * @author Armando Sosa
	 */
	function legacyPostImage( $id ){

		$image = self::tryToGetFromCustomField( $id );
		if ( ! empty( $image ) ) {
			return $image;
		}

		$image = self::tryToGetFirstAttachment( $id );
		if ( ! empty( $image ) ) {
			return $image;
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
	function tryToGetFromCustomField( $id ){
		$keyMatch = "/image/";
		$meta_values = get_post_custom( $id );

		foreach ( $meta_values as $key => $value ) {
			if ( preg_match( $keyMatch, $key ) ) {
				if ( is_array( $value ) ) {
					$value = $value[0];
				}
				if ( ! empty( $value ) ) {
					return $value;
				}
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
	function tryToGetFirstAttachment( $id ){

        $attachments = get_children( array(	'post_parent' => $id, 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC',  'orderby' => 'menu_order date') );
		if ( ! empty( $attachments ) ) { // Search for and get the post attachment

			foreach ( $attachments as $attachment ) {
				$image = $attachment->guid;
			}

			if ( ! empty( $image ) ) {
				return $image;
			}
		}

		return false;
	}


}