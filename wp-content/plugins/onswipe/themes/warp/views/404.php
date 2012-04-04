<?php
$this->layout = 'empty';

global $more, $post;

$more = true;		
$singleOrPage = (is_single() || is_page());
$title = get_bloginfo('name');
$use_static_front_page = get_option( 'show_on_front', false ) === 'page';
$back_url = get_option( 'show_on_front', false ) === 'page' ? get_permalink(get_option('page_for_posts',false)) : get_bloginfo('url');

?>

<section id="not_found" class="FlanModal opened">
	<div class="inner">
		<a href="<?php echo $back_url ?>" class="back button"><?php echo word_truncate($title,28) ?></a>

		<div id="copy_404">
			<div class="image">
				<img src="<?php echo PADPRESS_PLUGIN_URL."/themes/warp/assets/images/astronaut.png" ?>" alt="" />				
			</div>
			<p class="copy"><?php _e( 'Apologies, but the page you requested could not be found.', 'padpressed' ); ?></p>
			<a href="<?php echo $back_url ?>" class="back"><?php _e('Take me to the front page','frontpage') ?></a>
		</div>
	</div>
</section>