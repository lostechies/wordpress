<?php
define( 'PYGMENT_THEME', 'inkpot' );
define( 'PYGMENT_CACHE_VAR', 'pygment_cache' );
define( 'PYGMENT_CACHE_HASH_VAR', 'pygment_cache_hash' );
define( 'PYGMENT_HASH', 'crc32b' );
define( 'PYGMENT_SHORTCODE_NAME', 'code' );
define( 'PYGMENT_LANGUAGE_ATTRIBUTE', 'language' );
// comment out the below line if using the built-in webservice:
// define( 'PYGMENT_SERVICE_URL', 'http://pygments.appspot.com/' );
// uncomment the below lines if using the built-in webservice:
define( 'PYGMENT_SERVICE_SECRET_VAR', 'secret');
define( 'PYGMENT_SERVICE_SECRET_KEY', 'MZ##l}`AJ15HqG/:12Qi{o]}DG_/^xD5?#WZGiR5D-^=BI6.+#YC?VBK%]Z8BZAr' );
if ( function_exists( 'plugins_url' ) )
{
	define( 'PYGMENT_SERVICE_URL', plugins_url( '/webservice.php', __FILE__ ) );
}/**/
define( 'PYGMENT_SERVICE_CODE_VAR', 'code' );
define( 'PYGMENT_SERVICE_LANG_VAR', 'lang' );
define( 'PYGMENT_STYLE_NAME', 'pygment-style' );
define( 'PYGMENT_BLOCK_EXTRA_CLASSES', 'code' );
// set to false to hide a notice when the pygmented
// HTML is first retrieved from the webservice. Use
// to help trouble shoot (or to set your mind at ease
// as to when the webservice is being contacted).
define( 'DISPLAY_WEBSERVICE_NOTICE', TRUE );