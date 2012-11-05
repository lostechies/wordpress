<?php

// set the cahce directory for PBData. Use system's TEMP directory if available.
if ( ! ini_get( 'safe_mode' ) && is_writable( sys_get_temp_dir() ) )
	define( 'FILE_CACHE_DIRECTORY', '' );
else
	define( 'FILE_CACHE_DIRECTORY', './cache' );


if( ! defined( 'NOT_FOUND_IMAGE' ) )   define( 'NOT_FOUND_IMAGE', '' );	//Image to serve if any 404 occurs
if( ! defined( 'ERROR_IMAGE' ) )       define( 'ERROR_IMAGE', '' );	//Image to serve if an error occurs instead of showing error message