<?php

// is selfhosted?
defined( 'SELF_HOSTED' ) || define( 'SELF_HOSTED', true );
defined( 'PBDATA_USE_TRANSIENTS' ) || define( 'PBDATA_USE_TRANSIENTS', false );

// we'll use this library a lot.
if ( ! function_exists( 'wp_remote_request' ) )
	require_once( ABSPATH . WPINC . '/http.php' );

// global directory definitions
define( 'ONSWIPE_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'ONSWIPE_PLUGIN_INCLUDES', ONSWIPE_PLUGIN_DIR . '/includes' );

// load util functions
require_once( ONSWIPE_PLUGIN_INCLUDES . '/util-functions.php' );

// load old API
require_once( ONSWIPE_PLUGIN_INCLUDES . '/old-api.php' );

// constant for the plugin url
if ( str_contains( 'mu-plugins', __FILE__ ) )
	// a multisite installation
	define( 'ONSWIPE_PLUGIN_URL', content_url() . '/' . wp_basename( dirname( dirname( __FILE__ ) ) ) );
else
	// a stabndard installation
	define( 'ONSWIPE_PLUGIN_URL', plugins_url() . '/' . wp_basename( dirname( dirname( __FILE__ ) ) ) );


// production
defined( 'ONSWIPE_ASSETS_URL' )   || define( 'ONSWIPE_ASSETS_URL', 'http://cdn.onswipe.com/reader/onswipe-pub' );
defined( 'ONSWIPE_PUB_CSS_URL' )  || define( 'ONSWIPE_PUB_CSS_URL', ONSWIPE_ASSETS_URL . '/css' );
defined( 'ONSWIPE_PUB_JS_URL' )   || define( 'ONSWIPE_PUB_JS_URL', ONSWIPE_ASSETS_URL . '/js' );
defined( 'ONSWIPE_SC_JS_URL' )    || define( 'ONSWIPE_SC_JS_URL', ONSWIPE_ASSETS_URL . '/js/sc' );


// set the cache directory for PBData. Use system's TEMP directory if available.
if ( ! ini_get( 'safe_mode' ) && is_writable( sys_get_temp_dir() ) )
	defined( 'PBDATA_CACHE_DIR' ) || define( 'PBDATA_CACHE_DIR', sys_get_temp_dir() );
else
	defined( 'PBDATA_CACHE_DIR' ) || define( 'PBDATA_CACHE_DIR', dirname( __FILE__ ) . '/pbcache' );

if ( is_admin() )
	require_once( ONSWIPE_PLUGIN_INCLUDES . '/tour.php' );

require_once(ONSWIPE_PLUGIN_DIR . '/addons/cache.php');