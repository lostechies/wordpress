<div id="ads" class="widget-area">
			<ul class="xoxo">			
				<li id="archives" class="widget-container">
					<h3 class="widget-title">Ads</h3>
					<ul>
						<script src="https://m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
						<div id="default_demo"></div>
						<script>
						(function(){
						  // format, zoneKey, segment:value, options
						  _bsa.init('default', 'CVAIVKJE', 'placement:demo', {
						    target: '#default_demo',
						    align: 'horizontal',
						    disable_css: 'true'
						  });
						})();
						</script>

					</ul>
				</li>
						
			</ul>

			
		</div><!-- #ads .widget-area -->		
<div id="primary" class="widget-area">
			<ul class="xoxo">
				<?php if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : // begin primary widget area ?>			
				<li id="archives" class="widget-container">
					<h3 class="widget-title"><?php _e( 'Archives', 'twentyten' ); ?></h3>
					<ul>
						<?php wp_get_archives( 'type=monthly' ); ?>
					</ul>
				</li>
				<?php endif; // end primary widget area ?>		
						
			</ul>

			
		</div><!-- #primary .widget-area -->

		
		<div id="secondary" class="widget-area">
				
				<ul class="xoxo">		
					<?php if ( ! dynamic_sidebar( 'secondary-widget-area' )  ) : // Nothing here by default and design ?>
					<?php endif; ?>
				</ul>	
				
		</div><!-- #secondary .widget-area -->
