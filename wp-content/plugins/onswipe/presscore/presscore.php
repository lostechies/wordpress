<?php

require_once( 'bootstrap.php' );

class PressCore{

	public $version = '2.1.5b';

	/**
	 * Default options
	 *
	 * @var string
	 */
	public $options = array(
		'enabled'         => 'enabled',
		'accent_color'    => '#0081ff',
		'font'            => 'Arvo',
		'toc_layout'      => '',
		'article_layout'  => '',
		'logo'            => '',
		'icon'            => false,
		'loading_screen'  => false,
	);

	/**
	 * If set to true, Onswipe will be loaded regardless of the other conditions.
	 *
	 * @var string
	 */
	private $force_always = false;

	/**
	 * The Reader version supported by this plugin version.
	 *
	 * @var string
	 */
	public $reader_version = '1.1.0';

	/**
	 * Is this version of the reader still officially supported?
	 *
	 * @var string
	 */
	public $reader_supported = false;

	/**
	 * Constructor
	 *
	 * @author Armando Sosa
	 */
	function __construct(){

		$this->check_reader_version();

		// set default options
		$this->init_options();

		if ( defined( 'DOING_AJAX' ) ) {
			$this->ajax_hook( 'get_ad' );
			$this->ajax_hook( 'after_assetgen' );
		}

		if ( is_admin() ) {
			require_once( ONSWIPE_PLUGIN_INCLUDES . '/settings.php' );
		}

		add_action( 'save_post', array( $this, 'save_post_hook' ) );

	}

	/**
	 * Gets everything started.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function start(){


		// intercept the template redirect call
		add_action( 'template_redirect', array( $this, 'pbdata_hook' ) );

		if ( $this->is_enabled() ) {
			
			if ( $this->is_device() ){
				// so the thumbnail functions are available
				add_theme_support( 'post-thumbnails' );

				// intercept the template redirect call to redirect single posts
				add_action( 'template_redirect', array( $this, 'redirect_single' ) );

				// let's configure the mobile theme
				if ( ! is_admin() ) {
					add_filter( 'theme_root', create_function( null, 'return ONSWIPE_PLUGIN_DIR;' ) );
					add_filter( 'theme_root_url', create_function( null, 'return ONSWIPE_PLUGIN_URL;' ) );
					add_filter( 'template', array( $this, 'change_theme' ) );
					add_filter( 'stylesheet', array( $this, 'change_theme' ) );
					wp_enqueue_script( 'reader', "http://cdn.onswipe.com/reader/reader-{$this->reader_version}.min.js" );
				}

				if ( isset( $_GET['comments_popup'] ) ) {
					require_once( ONSWIPE_PLUGIN_INCLUDES . '/comment-functions.php' );
				}
			} else {
				add_action( 'wp_head', array( $this, 'reverse_redirect' ) );
			}
		}
	}

	/**
	 * Gets the list of supprted versions from Onswipe's CDN. Checks if it's compatible with current plugin.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function check_reader_version(){

		$versions = get_transient( 'onswipe_reader_versions' );
		$versions = false;

		if ( false === $versions ) {
			$url = 'http://cdn.onswipe.com/reader/supported.txt';

			$response = wp_remote_get( $url );

			if ( ! is_wp_error( $response )  ) {
				$versions = explode( "\n", $response['body'] );
			}
		}

		if ( ! empty( $versions ) ) {
			$this->reader_supported = in_array( $this->reader_version, $versions );
			set_transient( 'onswipe_reader_versions', $versions, 60 * 60 * 24 * 7 ); // seven days.
		}


	}

	/**
	 * Activation Hook
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	static function activate(){

		error_reporting( 0 );
		
		$url  = 'http://r.wp.onswipe.com/v1/data';
		$args = array(
			'body' => array(
				'url'   => get_bloginfo( 'url' ),
				'title' => get_bloginfo( 'name' ),
			)
		);

		$response = wp_remote_post( $url, $args );
	}


	/**
	 * Deactivation Hook
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	static function deactivate(){

		// delete options
		delete_option( 'onswipe_options' );
		delete_option( 'onswipe_installed' );
		delete_option( 'onswipe_layout_generated' );
		delete_option( 'onswipe_hide_welcome' );
		
		// delete transients
		delete_transient( 'onswipe_layouts' );
		delete_transient( 'onswipe_reader_versions' );

	}


	/**
	 * initialize default options so there's no need to go to the options first.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function init_options(){


		$is_admin = is_admin();
		$is_pbdata = isset( $_GET['pbdata'] );

		if ( $this->is_device() || $is_admin || $is_pbdata ) {
			$current_options = get_option( 'onswipe_options' );

			if ( false === $current_options ) {
				$current_options = array();
				add_option( 'onswipe_options', $current_options );
			}

			$this->options = wp_parse_args( $current_options, $this->options );

			if ( $is_admin || isset( $_GET['page'] ) && 'Onswipe' === $_GET['page'] ) {
				update_option( 'onswipe_options', $this->options );
			}
		}
	}

	/**
	 * little helper to attach an action to a admin-ajax
	 *
	 * @param string $action
	 * @return void
	 * @author Armando Sosa
	 */
	function ajax_hook( $action ){

		if ( method_exists( $this, $action ) ) {
			add_action( "wp_ajax_nopriv_$action", array( $this, $action ) );
			add_action( "wp_ajax_$action", array( $this, $action ) );
		}

	}

	/**
	 * Returns the reader demi-template
	 *
	 * @param string $path
	 * @return void
	 * @author Armando Sosa
	 */
	function change_theme( $path ){
		return 'reader';
	}

	/**
	 * Hooks into 'templare_redirect' and generates json pbdata for the reader
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function pbdata_hook(){

		if ( isset( $_GET['pbdata'] ) ) {
			require_once( ONSWIPE_PLUGIN_INCLUDES . '/pbdata.php' );
			$pbdata = pbdata_factory( $_GET['pbdata'] );

			if ( is_wp_error( $pbdata ) ) {
				echo $pbdata->get_error_message();
			} else {
				$pbdata->print_data();
			}

			// Not sure if this is necessary, but we don't want open connections left. Do we?
			do_action( 'shutdown' );
			wp_cache_close();

			// let's prevent WP Super Cache from outputting an error
			$_SERVER[ 'REQUEST_URI' ] .= '&wp-admin';

			die;
		}

	}

	/**
	 * Gets fired up upon post save/update
	 *
	 * @param string $post_id
	 * @return void
	 * @author Armando Sosa
	 */
	function save_post_hook( $post_id ){

		// skip revisions.
		if ( ! wp_is_post_revision( $post_id ) ) {
			require_once( ONSWIPE_PLUGIN_INCLUDES . '/pbdata.php' );

			// reset the index cache
			pbdata_factory( 'entries' )->reset();

			// reset this entry cache
			$pb_entry     = pbdata_factory( 'entry' );
			$pb_entry->id = $post_id;
			$pb_entry->reset();
		}
	}

	/**
	 * Acts as a cross domain proxy for ads.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function get_ad(){

		if ( isset( $_GET['cdp'] ) ){
			$url = 'http://ads.onswipe.com/random/embed:yes';

			// request the url
			$response = wp_remote_get( $url );

			echo $response['body'];
			die;
		}
	}

	/**
	 * Is this a supported device?
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function is_device(){

		$is_device_supported = false;

		// we are set to force support, so there we go.
		if ( $this->force_always ) {
			return true;
		}

		// Reader version is outdated. Sorry dude. You should update.
		// maybe this should go on is_device? Not sure. Jan 26 2011
		if ( false === $this->reader_supported ) {
			return false;
		}


		if ( isset( $_SERVER['HTTP_USER_AGENT'] ) ) {
			$agent = $_SERVER['HTTP_USER_AGENT'];
			
			if ( ! str_contains( 'safari', strtolower( $agent ) ) ) {
				return false;
			}

			$devices = '/ipad/';
			$agent = strtolower( $agent );
			$is_device_supported = preg_match( $devices, $agent, $matches );
		}

		return $is_device_supported;
	}

	/**
	 * Is the plugin enabled?
	 *
	 * This method is going to need serious refactoring. A.S.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function is_enabled(){

		// is there a onswipe_redirect variable?
		if ( isset( $_GET['onswipe_redirect'] ) ){
			$redirect = $_GET['onswipe_redirect'];
			if ( 'yes' === $redirect ) {
				$this->force_always = true;
			}
		}

		// we are set to force support, so there we go.
		if ( $this->force_always ) {
			return true;
		}

		// plugin is disabled. give up.
		if ( $this->options['enabled'] !== "enabled" ) {
			return false;
		}

		if ( ! is_admin() ) {
			// check if there's an onswipe redirect in the url.
			if ( isset( $redirect ) ) {
				if ( 'no' == $redirect ) {
					// temporary opt-out
					return false;
				} elseif ( 'never' == $redirect ){
					// definitive opt-out
					$this->set_optout_cookie();
					return false;
				} elseif ( 'yes' == $redirect ){
					// force opt-in
					$this->del_optout_cookie();
					return true;
				}

				return false;
			}


			if ( 'NAY' === $this->get_optout_cookie() ) {
				return false;
			}
		}


		return true;
	}

	/**
	 * Set an optout cookie;
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function set_optout_cookie(){
		$expire = time() + 60 * 60 * 24 * 7; // "Seven Days" -- Samara Morgan
		setcookie( 'ONSWIPE_OPTIN', 'NAY', $expire, '/' );
	}

	/**
	 * Delete an optout cookie;
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function del_optout_cookie(){
		$expire = time() - 60 * 60 * 24 * 7;
		setcookie( 'ONSWIPE_OPTIN', 'YAY', $expire, '/' );
	}

	/**
	 * gets the contents of the optin cookie
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function get_optout_cookie(){

		$cookie = 'YAY';

		if ( isset( $_COOKIE['ONSWIPE_OPTIN'] ) ) {
			return $_COOKIE['ONSWIPE_OPTIN'];
		}

		return $cookie;

	}

	/**
	 * Naive implementation of Synapse
	 *
	 * @return void
	 *
	 *
	 *
	 *
	 *
	 * @author Armando Sosa
	 */
	function redirect_single(){

		if ( is_single() || is_page() ) {
			if ( is_front_page() )
				return;

			global $post;

			$slug = preg_replace( '/\s/', '-', preg_replace( '/[^a-zA-z\s]/', '', strtolower( $post->post_title ) ) );
			$press_url = trailingslashit( get_bloginfo( 'url' ) ) . '?onswipe_redirect=yes' . '#!/entry/' . $slug . ',' . $post->ID;

			wp_redirect( $press_url );

			exit;
		}
	}

	/**
	 * Makes presscore urls work with non iPad version
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function reverse_redirect(){
		?>
		<script type="text/javascript" charset="utf-8">
			var href = "<?php bloginfo( 'url' ) ?>";
			// solves the issue where app mode does not set the correct UA String.
			if ( window.navigator.standalone ) {
				href += "?onswipe_redirect=yes";
				location.href = href;
			};
			try{
			// make reader urls work backwards.
				href += "?p=" + location.hash.match(/\#!\/entry\/.+,(\d+)$/)[1];
				location.href = href;
			}catch(e){}		
		</script>
		<?php
	}


	/*
		Ajax hook for after assetgen has been executed.
	*/
	function after_assetgen(){

		update_option( 'onswipe_layout_generated', true );
		die( 'assetgen finished' );

	}

}

/*
	Start The Whole Thing
*/

global $Onswipe;
$Onswipe = new PressCore;


