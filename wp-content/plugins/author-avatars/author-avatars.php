<?php
/*
Plugin Name: Author Avatars List
Plugin URI: http://authoravatars.wordpress.com/
Description: Display lists of user avatars using <a href="widgets.php">widgets</a> or <a href="https://authoravatars.wordpress.com/documentation/">shortcodes</a>.
Version: 1.2-dev
Author: <a href="http://bearne.com">Paul Bearne</a>, <a href="http://mind2.de">Benedikt Forchhammer</a>
Text Domain: author-avatars
Domain Path: /translations/
*/

// The current version of the author avatars plugin. Needs to be updated every time we do a version step.
define('AUTHOR_AVATARS_VERSION', '1.1');
// List of all version, used during update check. (Append new version to the end and write an update__10_11 method on AuthorAvatars class if needed)
define('AUTHOR_AVATARS_VERSION_HISTORY', serialize(Array('0.1', '0.2', '0.3', '0.4', '0.5', '0.5.1', '0.6', '0.6.1', '0.6.2', '0.7', '0.7.1', '0.7.2', '0.7.3', '0.7.4', '0.8', '0.9', '1.0', '1.1')));

require_once('lib/AuthorAvatars.class.php');
new AuthorAvatars();

?>