<?php

namespace WP_CLI;

use WP_CLI;

/**
 * A Core Upgrader class that caches the download, and uses cached if available
 *
 * @package wp-cli
 */
class CoreUpgrader extends \Core_Upgrader {

	function download_package( $package ) {

		/**
		 * Filter whether to return the package.
		 *
		 * @since 3.7.0
		 *
		 * @param bool    $reply   Whether to bail without returning the package. Default is false.
		 * @param string  $package The package file name.
		 * @param object  $this    The WP_Upgrader instance.
		 */
		$reply = apply_filters( 'upgrader_pre_download', false, $package, $this );
		if ( false !== $reply )
			return $reply;

		if ( ! preg_match('!^(http|https|ftp)://!i', $package) && file_exists($package) ) //Local file or remote?
			return $package; //must be a local file..

		if ( empty( $package ) )
			return new WP_Error( 'no_package', $this->strings['no_package'] );

		$filename = pathinfo( $package, PATHINFO_FILENAME );
		$ext = pathinfo( $package, PATHINFO_EXTENSION );

		$temp = \WP_CLI\Utils\get_temp_dir() . uniqid('wp_') . '.' . $ext;

		$cache = WP_CLI::get_cache();
		$update = $GLOBALS['wp_cli_update_obj'];
		$cache_key = "core/{$filename}-{$update->locale}.{$ext}";
		$cache_file = $cache->has( $cache_key );

		if ( $cache_file ) {
			WP_CLI::log( "Using cached file '$cache_file'..." );
			copy( $cache_file, $temp );
			return $temp;
		} else {
			// We need to use a temporary file because piping from cURL to tar is flaky
			// on MinGW (and probably in other environments too).
			$temp = sys_get_temp_dir() . '/' . uniqid('wp_') . '.' . $ext;

			$headers = array('Accept' => 'application/json');
			$options = array(
				'timeout' => 600,  // 10 minutes ought to be enough for everybody
				'filename' => $temp
			);

			$this->skin->feedback( 'downloading_package', $package );

			/** @var \Requests_Response|null $req */
			$req = Utils\http_request( 'GET', $package, null, $headers, $options );
			if ( ! is_null( $req ) && $req->status_code !== 200 ) {
				return new \WP_Error( 'download_failed', $this->strings['download_failed'] );
			}
			$cache->import( $cache_key, $temp );
			return $temp;
		}

	}

}
