<style type="text/css">

<?php 
global $Options;
$displayFont = $Options->get( 'padpress_warp', 'display_font' );

$skin = $Options->get( 'padpress_warp', 'color_skin' );
if ( $skin !== 'default' ) {
	$skin_path = staticize_subdomain( PADPRESS_THEME_DIR . "/assets/css/skins/{$skin}.css" );
	if ( file_exists( $skin_path ) )
		include( $skin_path );
}

if ( $displayFont !== '0' ) {
?>
#entry .entry .alignleft,
#entry .entry .alignright,
#entry .entry .aligncenter,
#entry .entry img.alignleft,
#entry .entry img.alignright,
#entry #comments .comments-title,
#cover header.cover-title,
#contents .section-header h1,
#contents .grid-item .post-title,
.entries-archive .section-header h1,
.entries-archive .archive-entries-container .entry .inner h1,
entries-archive .archive-entries-container .entry:nth-child(2) .inner h1,
#entry .entry .entry-title h1 {
  font-family: <?php echo $displayFont; ?>;
}
<?php
}
?>
</style>