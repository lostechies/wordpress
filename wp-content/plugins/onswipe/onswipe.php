<?php
/*
	Plugin Name: Onswipe
	Plugin URI: http://onswipe.com/wordpress
	Description: Onswipe makes it insanely easy to make your content look great on all touch devices. Preview it now for iPad and Wordpress.
	Author: Onswipe
	Version: 1.0
	Author URI: http://onswipe.com
*/


/**
 * global constant for the plugin directory
 */
define( 'PADPRESS_PLUGIN_DIR', dirname(__FILE__) );

/**
 * global constant for the framework directory
 */
define( 'PADPRESS_FRAMEWORK_DIR', PADPRESS_PLUGIN_DIR . '/framework' );

/*
	this are utility functions
*/
require_once( PADPRESS_FRAMEWORK_DIR . '/functions.php' );
require_once( PADPRESS_FRAMEWORK_DIR . '/api.php' );

/**
 * global constant that points to the url where the plugin lives.
 * we should guess if it's inside mu-plugins
 */
if ( str_contains( 'mu-plugins', __FILE__ ) )
	define( 'PADPRESS_PLUGIN_URL', content_url() . '/mu-plugins/' . wp_basename( dirname(__FILE__) ) );
else
	define( 'PADPRESS_PLUGIN_URL', plugins_url() . '/' . wp_basename( dirname(__FILE__) ) );

function is_padpressed_disabled() {
	$disabled = get_option( 'padpressed_is_disabled' );

	// if a site has mobile themes disabled, disable padpressed by default
	if ( false === $disabled && 1 == get_option( 'wp_mobile_disable' ) )
		$disabled = 1;

	return $disabled;
}

/**
 * This is the 'heart' of the plugin. It's an PHP5 class so everything gets instantiated with the constructor.
 *
 * @package default
 * @author Armando Sosa
 */
class PadPressEnabler {

	/**
	 * Plugin's version
	 *
	 * @var string
	 */
	var $version = '1.0';

	/**
	 * Theme name. Hardcoded for now.
	 *
	 * @var string
	 */
	var $theme = 'warp';

	/**
	 * Wether the user opted out of using the theme
	 *
	 * @var string
	 */
	var $optout;

	/**
	 * Supported devices. iPad only, for now.
	 *
	 * @var string
	 */
	var $supportedDevices = array(
		'ipad'
	);

	/**
	 * whether the site is being accessed by a mobile device.
	 *
	 * @var string
	 */
	var $isMobile = false;

	/**
	 * actual device
	 *
	 * @var string
	 */
	var $device = null;

	/**
	 * useful for development. Prevents the chore of setting the UA
	 *
	 * @var string
	 */
	var $development = false;

	/**
	 * undocumented variable
	 *
	 * @var string
	 */
	var $menu;

	/**
	 * Whether the thumbs cahe dir is writtable or not.
	 *
	 * @var string
	 */
	var $thumbsDirWritable = false;

	/**
	 * Class constructor
	 *
	 * @author Armando Sosa
	 */
	function __construct() {

		// set the theme.
		$__theme = get_option( 'padpressed_theme' );
		if ( is_string( $__theme ) && is_dir( PADPRESS_PLUGIN_DIR . '/themes/' . $__theme ) )
			$this->theme = $__theme;

		$this->setup();
		add_theme_support('post-thumbnails');
		
		// this will enable the full onswipe platform
		add_action( 'wp_head', array($this,'onswipejs') );
		
	}

	/**
	 * Detects if the site is being accesed by a supported device and acts accordingly
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function setup() {
		add_filter( 'admin_menu', array( $this, 'createMenu' ) );
		$this->setThemeOptions();

		$is_disabled = is_padpressed_disabled();

		if ( $is_disabled )
			return;

		if ( isset($_GET['padpressed_opt']) && $_GET['padpressed_opt'] === 'nay' )
			$this->optout = true;

		if ( !is_admin() && $this->isMobileAndSupported() && !$this->optout || $this->development ) {
			$this->isMobile = true;

			$themePath =  PADPRESS_PLUGIN_DIR . '/themes/' . $this->theme;

			if ( ! defined('PADPRESS_THEME_DIR') )
				define( 'PADPRESS_THEME_DIR', $themePath );

			if ( function_exists( 'wpcom_is_vip' ) && wpcom_is_vip() )
				require_once get_template_directory() . '/functions.php';

			if ( file_exists( $themePath ) ) {
				add_filter( 'theme_root', array( $this, 'themeRoot' ) );
				add_filter( 'theme_root_uri', array( $this, 'themeRootUrl' ) );
				add_filter( 'template', array( $this, 'setTheme' ) );
				add_filter( 'stylesheet', array( $this, 'setStylesheet' ) );
				add_filter( 'show_admin_bar', '__return_false' );				
			}

			// Disable Custom CSS
			remove_action( 'init', 'safecss_init' );
			remove_filter( 'stylesheet_uri', 'safecss_style_filter' );

			// Disable Admin bar
			remove_action( 'init', 'wpcom_adminbar_init' );
			remove_action( 'wp_footer', 'wpcom_adminbar_render', 1000 );
			remove_action( 'wp_footer', 'admin_bar_query_debug_list' );
			remove_action( 'wp_head', 'wpcom_adminbar_css' );


		} else {
			add_filter( 'wp_head','hashbang_redirect' );
		}

	}

	function maybeRedirect() {
		$staticFrontPage = get_option( 'show_on_front', false ) === 'page';
		$blogPage = get_permalink( get_option( 'page_for_posts', false ) );
		if ( $staticFrontPage && is_front_page() )
			header( 'Location: ' . $blogPage );
	}


	function onswipejs(){
		$url = "http://plug.onswipe.com/on.js";
		if (is_single()) {
			global $post;
			$url .= "?wp_id={$post->ID}";
		}
		echo '<script src="'.$url.'" type="text/javascript" charset="utf-8"></script>';
	}

	/**
	 * Utility function to insert a file from the assets dir
	 *
	 * @param string $name
	 * @param string $type
	 * @return void
	 * @author Armando Sosa
	 */
	function asset( $name, $type = 'images' ) {
		return PADPRESS_PLUGIN_URL . "/assets/$type/$name";
	}

	/**
	 * Creates a Top Level admin menu for this plugin
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function createMenu() {
		global $menu;
		add_theme_page( 'Onswipe', 'Onswipe', 'manage_options', 'padpressed', array( $this, 'panel' ) );
	}

	/**
	 * Renders the plugin options page. Pretty simple stuff right now.
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function panel() {
		
		if ( isset( $_POST['padpressed_general']['enable'] ) ) {
			if ( $_POST['padpressed_general']['enable'] === 'enable' ) {
				update_option( 'padpressed_is_disabled', 0 );
				if ( function_exists( 'bump_stats_extras' ) )
					bump_stats_extras( 'onswipe', 'enabled' );
			} else {
				update_option( 'padpressed_is_disabled', 1 );
				if ( function_exists( 'bump_stats_extras' ) )
					bump_stats_extras( 'onswipe', 'disabled' );
			}
		} elseif ( false === get_option( 'padpressed_is_disabled' ) ) {
			// Set the option so a user won't be confused if they
			// change mobile and onswipe ends up changing as well
			if ( 1 == get_option( 'wp_mobile_disable' ) )
				update_option( 'padpressed_is_disabled', 1 );
			else
				update_option( 'padpressed_is_disabled', 0 );
		}

		$is_disabled = is_padpressed_disabled();

		include_once( PADPRESS_PLUGIN_DIR . '/framework/panel.php' );
	}

	/**
	 * gets an associative array of the themes in the themes folder
	 *
	 * @return void
	 * @author Armando Sosa
	 */
	function getThemesList() {
		// skins
		$themesdir = PADPRESS_PLUGIN_DIR . '/themes/';
		chdir( $themesdir );
		$dirs = glob( '*', GLOB_ONLYDIR );
		$themes = array();
		foreach ( $dirs as $dir ) {
			$themes[$dir] = ucfirst( $dir );
		}
		return $themes;
	}



	/* Filter callback functions */

	function setTheme( $themename ) {
		return $this->theme;
	}

	function setStylesheet( $cssname ) {
		return $this->theme;
	}

	function themeRoot( $path ) {
		if ( $this->isMobileAndSupported() || $this->development )
			return PADPRESS_PLUGIN_DIR . '/themes';
	}

	function themeRootUrl( $url ) {
		if ( $this->isMobileAndSupported() || $this->development )
			return PADPRESS_PLUGIN_URL . '/themes';
	}

	function setThemeOptions() {

		$themePath =  PADPRESS_PLUGIN_DIR . '/themes/' . $this->theme;

		require_once ( PADPRESS_PLUGIN_DIR . '/framework/options.class.php' );

		if ( file_exists( $themePath . '/init-options.php' ) )
			require_once ( $themePath . '/init-options.php' );

		if ( defined('DOING_AJAX') && file_exists( $themePath . '/ajax-functions.php' ) )
			require_once ( $themePath . '/ajax-functions.php' );
	}

	function isMobileAndSupported() {
		$supported = false;
		$agent = strtolower( $_SERVER['HTTP_USER_AGENT'] );
		foreach ( $this->supportedDevices as $device ) {
			if ( strpos( $agent, $device ) !== false ) {
				$supported = true;
				$this->device = $device;
				break;
			}
		}
		return $supported;
	}

}

new PadPressEnabler;
