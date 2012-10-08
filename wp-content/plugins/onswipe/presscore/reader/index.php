<?php global $Onswipe; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<!-- Pre-Configuration -->
<script type="text/javascript" charset="utf-8">
	window.PressCoreConfig = {
		base : '<?php echo bloginfo( 'url' ) ?>',
		pub_assets : '<?php echo layout_assets_url(); ?>',
		hashBase : '<?php echo trailingslashit( get_bloginfo( 'url' ) ) ?>'.replace( location.origin, '' ).replace( /^\/|\/$/g, '' ),
		cdp : "<?php echo admin_url( 'admin-ajax.php?action=get_ad&cdp=' ); ?>",
		pub_css : "<?php echo ONSWIPE_PUB_CSS_URL ?>/onswipe-pub.css"
	}
</script>
<!-- Reader framework -->
<script src="http://cdn.onswipe.com/reader/reader-<?php echo $Onswipe->reader_version ?>.min.js"></script>

</head>
<body></body>
</html>