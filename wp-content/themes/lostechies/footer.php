</div><!-- end div tabs see header.php -->
<?php switch_to_blog(1); ?>	
	<div id="footer">
		<div class="container_12">
		<div id="footer-widget-area">
				<div class="grid_4">					
					<ul>
					<li><a href="<?php bloginfo('url'); ?>" title="home">Home</a></li>
					<?php wp_list_pages('title_li='); ?>
					<li><a href="http://feeds.feedburner.com/LosTechies" rel="alternate" type="application/rss+xml"><img src="http://www.feedburner.com/fb/images/pub/feed-icon16x16.png" alt="" style="vertical-align:middle;border:0"/></a><a href="http://feeds.feedburner.com/LosTechies"><img src="http://feeds.feedburner.com/~fc/LosTechies?bg=FFFFFF&amp;fg=2E9BD2&amp;anim=1" height="26" width="88" style="vertical-align:middle;border:0"/></a></li>
					</ul>
				</div><!-- #second .widget-area -->
				<div class="grid_4">
					
					<h3>Friends of Pablo</h3>
<ul>
<li><a href="http://www.watchmecode.net" target="_blank">WatchMeCode</a></li>
<li><a href="http://tekpub.com" target="_blank">TekPub</a></li>
<li><a href="http://www.pec.stedwards.edu/" target="_blank">St. Edward's Professional Education Center</a></li>
<li><a href="http://www.pragprog.com/" target="_blank">Pragmatic Bookshelf</a></li>
<li><a href="http://www.jetbrains.com/resharper/" target="_blank">ReSharper - Develop with Pleasure!</a></li>
<li><a href="http://www.nhprof.com/" target="_blank">NHProf</a></li>

</ul>				
				</div><!-- #third .widget-area -->
				<div class="grid_4">
					<h3>Pablo's Extended Family</h3>
<ul>
<li><a href="http://codebetter.com" target="_blank">CodeBetter</a></li>
<li><a href="http://devlicio.us" target="_blank">Devlicious</a></li>
<li><a href="http://dimecasts.net" target="_blank">Dimecasts</a></li>
<li><a href="http://elegantcode.com" target="_blank">ElegantCode</a></li>
</ul><br/>
					<?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?><br />
						<?php bloginfo('description'); ?><br />
				<?php printf( __( 'Proudly powered by <span id="generator-link">%s</span>.', 'twentyten' ), '<a href="http://wordpress.org/" title="' . esc_attr__( 'Semantic Personal Publishing Platform', 'twentyten' ) . '" rel="generator">' . __( 'WordPress', 'twentyten' ) . '</a>' ); ?>
				<br/><br/>
				<a href="http://www.rackspace.com" target="_blank"><img src="http://e6b031908a72d151cb58-e811db8ece5abf3fe1b6c8e3c1955f7f.r83.cf1.rackcdn.com/powered-by-rs-40.jpg" /></a>
					
				</div><!-- #fourth .widget-area -->
			</div><!-- #footer-widget-area -->		
		
			</div><!-- end div.container_12 -->

	</div><!-- end div#footer -->
		<?php restore_current_blog(); ?>
<!-- GOOGLE ANALYTICS -->
<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
try {
var pageTracker = _gat._getTracker("UA-1265430-2");
pageTracker._trackPageview();
} catch(err) {}</script> 

<?php
        /* Always have wp_footer() just before the closing </body>
         * tag of your theme, or you will break many plugins, which
         * generally use this hook to reference JavaScript files.
         */

        wp_footer();
?>

</body>
</html>
