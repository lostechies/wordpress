<!DOCTYPE HTML>
<html>
<head>
	<title><?php bloginfo('name') ?></title>
	<meta charset="UTF-8">
	
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" type="text/css" media="screen" title="no title" charset="utf-8">
	<?php include(PADPRESS_THEME_DIR."/views/_fontstyles.php");?>
	<?php
	global $Options;
	$skin = $Options->get('padpress_warp','skin');

	if ( $skin ) {
		$url = staticize_subdomain( get_bloginfo( 'template_directory' ) . "/assets/css/skins/$skin.css" );
		?>
		<link rel="stylesheet" href="<?php echo $url ?>" type="text/css" media="screen"  charset="utf-8">
		<?php
	}

	?>

	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />	
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta name="apple-mobile-web-app-capable" content="yes" />	

	<?php
		$logo_url = thumbgen($Options->get('padpress_warp','cover_logo'),72,72);
		if (str_contains('void.gif',$logo_url)) $logo_url = '';
		if (!empty($logo_url)) {
			echo "<link rel='apple-touch-icon' href='$logo_url'>";			
		}
	?>
	
	<?php
		$launch_screen = $Options->get('padpress_warp','launch_screen');
		if (!empty($launch_screen)) {
			echo "<link rel='apple-touch-startup-image' href='$launch_screen'>";
		}
	?>	
	
	<?php hashbang_redirect(); ?>
	
	<?php wp_head() ?>
	
	
</head>
<body <?php if (is_user_logged_in()) echo "class='logged-in'"; ?>>		

	<div id="wrapper">
		<div id="spinner">&nbsp;</div>		
		<?php $this->partial('menu') ?>			
		<?php echo $content_for_page; ?>
		<div id="pagination"></div>
	</div>
	<?php wp_footer(); ?>	
	<?php $this->partial('footer_vars') ?>
	
</body>
</html>