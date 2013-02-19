<?php
include( 'config.php' );

function bash_quote( $string )
{
	// replace ['] with ['\'']
	return $string = str_replace("'", "'\\''", $string );
};

$code = $_POST[PYGMENT_SERVICE_CODE_VAR];
$lang = $_POST[PYGMENT_SERVICE_LANG_VAR];
$secret = $_POST[PYGMENT_SERVICE_SECRET_VAR];
if ( $secret !== PYGMENT_SERVICE_SECRET_KEY )
{
	echo '<p>Key mismatch.</p>';
	die;
}
// escape any escape characters
$code = bash_quote( $code );
$lang = bash_quote( $lang );

$shell_command = "echo '$code' | pygmentize -f html -l '$lang'";
echo $output = shell_exec( $shell_command );