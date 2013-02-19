<?php
// a simple script to test the built-in webservice
include ( 'config.php' );
$path = str_replace( '/test.php', '/webservice.php', $_SERVER[REQUEST_URI]);
$url = $_SERVER[HTTP_HOST] . $path;
echo "<p>Service URL: " . $url . '</p>';
include ( 'functions.php' );
$code = 'function test() { echo "this is it";}';
"$code is the code";
$lang = 'php';
echo $result = get_pygment( $code, $lang, $url );
