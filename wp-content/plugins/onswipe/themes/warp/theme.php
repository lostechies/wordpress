<?php
/**
 * This class is the main code for the theme. It inits all the necessary hooks, 
 * and has some utility methods. It gets automatically instantiated and stored in 
 * the globl variable $t.
 *
 * @package default
 * @author Armando Sosa
 */
class PadpressTheme{
	
	/**
	 * constructor
	 *
	 * @author Armando Sosa
	 */
	function __construct(){
		
		add_filter('excerpt_length', array($this,'excerptLength'));		
		add_filter('the_title', array($this,'formatTitle'));		
		add_filter('option_blogname', array($this,'formatBlogName'));		
		add_theme_support('post-thumbnails');					

		if (!is_admin()){
			add_action( 'wp_print_scripts', array($this,'printScripts') );
		} 
		
		if (defined('DOING_AJAX')) {
			$this->ajaxHook('getLastPost');
			$this->ajaxHook('getArchive');
			$this->ajaxHook('getComments');
			$this->ajaxHook('getCommentsForm');
			$this->ajaxHook('postComment');
		}
		
				
	}
	
	/**
	 * little helper to attach an action to a admin-ajax
	 *
	 * @param string $action 
	 * @return void
	 * @author Armando Sosa
	 */
	function ajaxHook($action){
		
		$hook = strtolower(preg_replace('/(?<=[a-z])([A-Z])/', '_$1', $action));
		
		if (method_exists($this,$action)) {
			add_action("wp_ajax_nopriv_$hook",array($this,$action));
			add_action("wp_ajax_$hook",array($this,$action));
		}

		
	}
	
	/**
	 * excerpt length
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function excerptLength(){
		return 20;
	}
	
	/**
	 * if global variable $truncate_title is set to a number, the title will be truncated to n number of characters.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function formatTitle($title){
		global $truncate_title;

		if (!empty($truncate_title)) {
			return word_truncate($title, $truncate_title);
		}
		
		return $title;

	}
	
	/**
	 * Filters the blog name and shows the url in case it is empty.
	 *
	 * @author Armando Sosa
	 */

	function formatBlogName($name){

		if (empty($name)) {
			$url = get_bloginfo('url');
			$name = str_replace('http://','',str_replace('.wordpress.com','',preg_replace('#\/$#','',$url)));
		}
		
		return $name;
	}
	
	/**
	 * Whether it has a thumbnail image or not.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function hasThumb(){
		global $id;
		if (has_post_thumbnail()) {
			return true;
		}else{
			$image = $this->legacyPostImage($id);
			return (!empty($image));
		}
	}
	
	/**
	 * hooks onto print_scripts
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function printScripts() {
		$scripts = array(
			'touchscroll',
			'swippable',
			'class',
			'flan',
			'flan.gestures',
			'flan.navigation',
			'popover',
			'videoiframe',
			'app',
		);

		$dir = get_bloginfo( 'template_directory' );
		foreach ( $scripts as $script ) {
			wp_enqueue_script( $script, staticize_subdomain( "$dir/assets/js/$script.js" ), array( 'jquery') );
		}
	}
	
	/**
	 * hooks onto print_styles
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function printStyles() {
		wp_enqueue_style( 'popover', staticize_subdomain( get_bloginfo( 'template_directory' ) . '/assets/css/popover.css' ) );
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
	function postImage($w = 280, $h = 180, $src_only = false, $link = false, $echo = true){

		global $post, $id;
		
		$post_id = $id;
		$post_thumbnail_id = get_post_thumbnail_id( $post_id );
		$class = $post->post_type."-image";
		$image = wp_get_attachment_image_src( $post_thumbnail_id, $size="regular");
		
		if (!$image) {
			$image = $this->legacyPostImage($id);
			if ($image === false) return false;
		}else{
			$image = $image[0];
		}
		
		if (!$w === false && !$h === false) {
			$src = thumbgen($image,$w,$h);
		}		
		
		if ($src_only) {
			return $src;
		}
	
		$output = "<img src=\"$src\" class=\"$class\"/>";
			
		if ($link) $output = "<a href=\"$link\">".$output."</a>";	

		$output = "<div class=\"entry-image\">$output</div>";
		
		if ($echo) {
			echo $output;			
		}
		
		return $output;
		
	}
	
	/**
	 * Does its best to return a thumbnail image when no native thumb
	 * has been defined.
	 *
	 * @param string $id 
	 * @return void
	 * @author Armando Sosa
	 */
	function legacyPostImage($id){
		
		$image = $this->tryToGetFromCustomField($id);
		if (!empty($image)) {
			return $image;
		}
		
		$image = $this->tryToGetFirstAttachment($id);
		if (!empty($image)) {
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
	function tryToGetFromCustomField($id){
		$keyMatch = "/image/";
		$meta_values = get_post_custom($id);

		foreach ($meta_values as $key => $value) {
			if (preg_match($keyMatch,$key)) {
				if (is_array($value)) {
					$value = $value[0];
				}
				if (!empty($value)) {
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
	function tryToGetFirstAttachment($id){
		
        $attachments = get_children( array(	'post_parent' => $id, 'numberposts' => 1, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'DESC',  'orderby' => 'menu_order date') );
		if ( !empty($attachments) ) { // Search for and get the post attachment       

			foreach ( $attachments as $attachment ) {  
				$image = $attachment->guid;
			}
			
			if (!empty($image)) {
				return $image;
			}
		}
		
		return false;
	}
	
	
	/**
	 * Returns the most suitable-sized image for the current post position in a grid
	 *
	 * @param string $pos 
	 * @return void
	 * @author Armando Sosa
	 */
	function postGridImage($pos){

		if (!$this->hasThumb()) return '';

		switch ($pos) {
			case 1:
				$image =  $this->postImage(710,250,true);
				break;

			case 2:
				$image = $this->postImage(430,250,true);
				break;
			
			default:
				$image = $this->postImage(370,250,true);
				break;
		}
		
		return $image;
		
		
		
	}
	
	
	/**
	 * Transform an object into json
	 *
	 * @param string $object 
	 * @return void
	 * @author Armando Sosa
	 */
	function jsonize($object){
        header( 'Cache-Control: no-cache, must-revalidate' );
        header( 'Content-type: application/json' );
		header( 'Access-Control-Allow-Origin: *' );
		header( 'Access-Control-Allow-Headers: X_REQUESTED_WITH' );
		echo json_encode($object);
		die;		
	}
	
	/**
	 * Serves an archive via json. 
	 *
	 * @author Armando Sosa
	 */
	function getArchive(){
		
		$object = array();
		extract($_GET);

		$category = esc_attr($category);


		if (isset($category) && category_exists((int) $category) || isset($all)  || $category == -1) {

			// query parameters
			$options = array(
				'posts_per_page'=>5,
				'post_status'=>'publish',
				'paged'=> ( isset($paged) ) ? $paged + 1 : 1
			);

			if ($category > 1) {
				$options['cat'] = $category;
			}


			// query for the posts
			query_posts($options);
			global $wp_query;

			$max_pages = $wp_query->max_num_pages;
			if (isset($all)) {
				$max_pages = ($max_pages < 20) ? $max_pages : 20;
			}

			// this is the meta information that we'll pass to the app
			$object['meta']	= array(
				'max_pages'=> $max_pages,
				'current_page'=>absint( get_query_var( 'paged' ) )
			);

			$pos = 0;
			// loop trough the posts and propagate the object array
			if (have_posts()) while (have_posts()){
				$pos++;
				the_post();
				
				// this is a hack to get full posts always				
				global $more, $post;
				$more = true;		
				
				// this is to get the content with all the filters without echoing it.
				$content = str_replace(']]>', ']]&gt;', apply_filters('the_content', get_the_content('')));
					
				// populate the object;				
				$postObject = array(
					'id'=>$post->ID,
					'author'=>get_the_author(),					
					'title'=>str_replace('&nbsp;',' ',get_the_title()), // sorry, but when titles are narrow we DO want widows.
					'date'=>get_the_date(),
					'gravatar'=>get_avatar(get_the_author_email(),'24'),
					'permalink'=>get_permalink(),
					'content'=>$content,
					'excerpt'=>get_the_excerpt(),
					'image'=>$this->postGridImage($pos),
					'comments_open'=>comments_open($post->ID),
					'comment_count'=>get_comments_number(),
					'shortlink'=>''
				);			
				
				// if a shortlink exists, let's use that.
				if (function_exists('wp_get_shortlink')) {
					$postObject['shortlink'] = wp_get_shortlink($post->ID,'post');
				}else {
					$postObject['shortlink'] = $postObject['permalink'];	
				}
				
				$object['posts'][] = $postObject;
			}

		}
				
		$this->jsonize($object);

	}
	
	
	function commentsTemplatePath(){
		return PADPRESS_THEME_DIR."/views/_comments.php";
	}
	
	function commentsWalkerCallback($comment, $args, $depth){
		global $user_ID, $comment_depth;
		$GLOBALS['comment'] = $comment;

		$noreply = false;
		if ( 0 == $depth || $args['max_depth'] <= $depth ){
			$noreply = true;
		}elseif ( get_option('comment_registration') && !$user_ID ){
			$noreply = true;
		}
		include(PADPRESS_THEME_DIR."/views/_comments-list.php");
	}
	
	
	function getComments(){
		extract($_GET);
		
		$p = query_posts( array( 'p' => $post_id) );

		if (empty($p))
		    $p = query_posts( array( 'page_id' => $post_id) );
		    		    
		if ( have_posts() ) {
			add_filter('comments_template',array($this,'commentsTemplatePath'));
			the_post();
			comments_template( '/views/_comments.php', true );			
		}
		exit;		
		die;
	}
	
	
	function getCommentsForm(){
		extract($_GET);

		if (isset($post_id)) {
			global $post, $id, $user_identity;
			$post_id = (int) $post_id;
			$post = get_post($post_id);
			$id = $post->ID;
			$commenter = wp_get_current_commenter();

			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? " aria-required='true'" : '' );

			$fields =  array(
				'author' => '<input id="author" class="text" name="author" type="text" placeholder="'.__('Your Name').'" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />',
				'email'  => '<input id="email" class="text" name="email" type="email" placeholder="'.__('Your Email').'" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />',
				'url'    => '<input id="url" class="text" name="url" type="url" placeholder="'.__('Your Website').'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />',
			);
			

			$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
			$defaults = array(
				'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
				'comment_field'        => '<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'._x( 'Comment', 'noun' ).'"></textarea>',
				'must_log_in'          => '<p class="msg must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
				'logged_in_as'         => '<p class="msg logged-in-as">' . sprintf( __( 'Hello <strong>%1$s</strong> <a href="%2$s" title="Log out of this account"><small>Not you?</small></a>' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
				'comment_notes_before' => '<p class="msg comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
				'comment_notes_after'  => '<p class="msg form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
				'id_form'              => 'commentform',
				'id_submit'            => 'submit',
				'cancel_reply_link'    => __( 'Cancel reply' ),
				'label_submit'         => __( 'Post Comment' ),
			);

			$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );
			
			include(PADPRESS_THEME_DIR."/views/_comments_form.php"); // sorry I hate inline html

		}
		
		die;
	}
	
	function postComment(){

		if ( 'POST' != $_SERVER['REQUEST_METHOD'])
		    die('&raquo;&mdash;&hearts;&rarr;');

		check_ajax_referer( 'ajaxnonce', '_ajax_post' );
		
		$comment_content = isset( $_POST['comment'] ) ? trim( $_POST['comment'] ) : null;
		$comment_post_ID = isset( $_POST['comment_post_ID'] ) ? trim( $_POST['comment_post_ID'] ) : null;

		$user = wp_get_current_user();

		if ( is_user_logged_in() ) {
			if ( empty( $user->display_name ) )
				$user->display_name = $user->user_login;
			$comment_author       = $user->display_name;
			$comment_author_email = $user->user_email;
			$comment_author_url   = $user->user_url;
			$user_ID 			  = $user->ID;
		} else {
			if ( get_option( 'comment_registration' ) ) {
			    die(__( 'Error: you must be logged in to post a comment.', 'padpressed' ));
			}
			$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
			$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
			$comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
		}

		$comment_type = '';

		if ( get_option( 'require_name_email' ) && !$user->ID )
			if ( strlen( $comment_author_email ) < 6 || '' == $comment_author ) {
				die( __( 'Error: please fill the required fields (name, email).', 'padpressed' ) );
			} elseif ( !is_email( $comment_author_email ) ) {
			    die( __( 'Error: please enter a valid email address.', 'padpressed' ) );
			}

		if ( '' == $comment_content )
		    die(__( 'Error: Please type a comment.', 'padpressed' ));

		$comment_parent = isset( $_POST['comment_parent'] ) ? absint( $_POST['comment_parent'] ) : 0;

		$commentdata = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID' );

		$comment_id = wp_new_comment( $commentdata );
		$comment = get_comment( $comment_id );
		
		if ((int)$comment->comment_approved === 0) {
			die(__('Your comment is waiting for approval'));
		}
		
		if ( !$user->ID ) {
			setcookie( 'comment_author_' . COOKIEHASH, $comment->comment_author, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie( 'comment_author_email_' . COOKIEHASH, $comment->comment_author_email, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			setcookie( 'comment_author_url_' . COOKIEHASH, esc_url($comment->comment_author_url), time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		}
				
		if ($comment){
			$this->jsonize($comment);
		}else{
			echo __("Error: Unknown error occurred. Comment not posted.", 'padpressed' );			
		}
		
		die;
	}

	/**
	 * Prints out a link to the selected skin css file.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
 	function skinStyle() {
 		global $Options;
 		$skin = $Options->get( 'padpress_warp' ,'skin' );
 
 		if ( $skin ) {
 			$url = staticize_subdomain( get_bloginfo( 'template_directory' ) . "/assets/css/skins/$skin.css" );
 			echo '<link rel="alternate" href="' . $url . '" type="text/css" media="screen" title="no title" charset="utf-8">';
 		}
 	}
	
}

global $t;
$t = new PadpressTheme;
