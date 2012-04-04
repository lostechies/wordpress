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

	if ($skin) {
		$url = get_bloginfo('template_directory')."/assets/css/skins/$skin.css";			
		?>
		<link rel="stylesheet" href="<?php echo $url ?>" type="text/css" media="screen"  charset="utf-8">			
		<?php		
	}
	
	?>
	
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />	
	
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta name="apple-mobile-web-app-capable" content="yes" />	
	
	
</head>
<body <?php if (is_user_logged_in()) echo "class='logged-in'"; ?>>		

	<div id="wrapper">
		<div id="spinner">&nbsp;</div>		
		<?php $this->partial('menu') ?>			
		<?php echo $content_for_page; ?>
		<div id="pagination"></div>
	</div>
	<?php wp_footer(); ?>	
		
</body>
</html>