<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php
        if ( is_single() ) {
			single_post_title(); echo ' | '; bloginfo( 'name' );
		} elseif ( is_home() || is_front_page() ) {
			bloginfo( 'name' ); echo ' | '; bloginfo( 'description' ); twentyten_the_page_number();
		} elseif ( is_page() ) {
			single_post_title( '' ); echo ' | '; bloginfo( 'name' );
		} elseif ( is_search() ) {
			printf( __( 'Search results for "%s"', 'twentyten' ), esc_html( $s ) ); twentyten_the_page_number(); echo ' | '; bloginfo( 'name' ); 
		} elseif ( is_404() ) {
			_e( 'Not Found', 'twentyten' ); echo ' | '; bloginfo( 'name' );
		} else {
			wp_title( '' ); echo ' | '; bloginfo( 'name' ); twentyten_the_page_number();
		}
    ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<link href="https://feeds.feedburner.com/LosTechies" title="LosTechies.Com &raquo; Feed" type="application/rss+xml" rel="alternate">
	<?php
		wp_enqueue_style( 'mainstyle', '/wp-content/themes/lostechies/style.css');
		wp_enqueue_style( 'jquerystyle', '/wp-content/themes/lostechies/jquery-ui-1.8.1.custom.css');	
	?>

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
	<style type="text/css">body { padding-top:0px !important; }</style>
        <script src="//m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
</head>

<body>

	<?php switch_to_blog(1); ?>		
		<div id="ui-tabs-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom"></div>
		<div id="ui-tabs-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide"></div>
			
		<div class="container_12">
		
			<div id="logo" class="grid_3"><a href="/" title="LosTechies.Com - <?php bloginfo('description'); ?>"><img src="/wp-content/themes/lostechies/images/lostechies_logo.png"/></a></div>
			<div id="globalNav" class="grid_12">
				<ul>
					<li><a href="<?php bloginfo('url'); ?>" title="home">Home</a></li>
					<?php wp_list_pages('title_li=&exclude=41'); ?>
					<li><a href="https://feeds.feedburner.com/LosTechies" rel="alternate" type="application/rss+xml"><img src="https://www.feedburner.com/fb/images/pub/feed-icon16x16.png" alt="" style="vertical-align:middle;border:0"/></a><a href="https://feeds.feedburner.com/LosTechies"><img src="https://feeds.feedburner.com/~fc/LosTechies?bg=EFEFEF&amp;fg=2E9BD2&amp;anim=1" height="26" width="88" style="vertical-align:middle;border:0"/></a></li>
				</ul>

<div class="bsa-cpc"></div>

								
			</div><!-- end div#globalNav.container_12 -->				
	<?php restore_current_blog(); ?>
