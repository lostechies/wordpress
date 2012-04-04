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
