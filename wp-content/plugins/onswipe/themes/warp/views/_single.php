<?php

global $more, $post;

$more = true;		
$singleOrPage = (is_single() || is_page());
$title = get_bloginfo('name');
$use_static_front_page = get_option( 'show_on_front', false ) === 'page';
$back_url = get_option( 'show_on_front', false ) === 'page' ? get_permalink(get_option('page_for_posts',false)) : get_bloginfo('url');
$is_ajax = is_ajax_request();
?>

<?php if (!$is_ajax): ?>
<section id="entry" <?php echo ($singleOrPage)?'class="FlanModal"':'' ?>>
<?php endif ?>
	<div class="inner">
		<?php if (have_posts()): the_post() ?>

            <?php if (!$is_ajax): ?>
    			<script type="text/javascript">
    				App.isSingle = true;
    				App.currentPostId = <?php echo $post->ID ?>;
    			</script>                
    			
    			<?php if (!(is_front_page() && $use_static_front_page)): ?>
    				<a href="<?php echo $back_url ?>" class="back button"><?php echo word_truncate($title,28) ?></a>					    
    			<?php endif ?>    			

                <a href="#" id="single-menu-button" class="button"></a>
    		
    		<?php else: ?>
    			<div id="close-btn">x</div>
            <?php endif ?>

            			
			<a href="#entries" class="share-btn" id="share-btn"><?php _e('share') ?></a>
			<?php if (comments_open($post->ID) || get_comments_number()) {
			?>
				<a href="#comments" class="comments-btn" id="comments-btn"><?php comments_number(0,1,'%') ?></a>					
			<?php
			} ?>
			<?php $this->partial('share-menu'); ?>
			<div class="scroller" id="entry-scroller">
				<div class="entry">
					<header class="entry-title">
						<h1><?php the_title() ?></h1>
						<div class="entry-meta">
							<span class="author">
								<?php echo get_avatar(get_the_author_email(),'24'); ?>
								<em><?php _e('by','padpressed') ?></em>
								<strong>
									<?php the_author() ?>
								</strong>
							</span>
							<span class="date"><?php the_date() ?></span>   							
						</div>
					</header>
					<div class="entry-body">
						<?php if (is_attachment()){
							$this->partial('attachment');							
						}else{
							the_content();							
						} ?>
						<div class='ons-branding'>Theme by <a href='http://onswipe.com/wordpress' title='Onswipe'>Onswipe</a></div>
					</div>
				</div>	
				
			</div>
		<?php endif ?>
		<?php if (!is_page()): ?>
			<div id='post-nav'>
				<div class="nav-inner">
				<?php 
					global $truncate_title;
					$truncate_title = 45;
					previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'padpressed' ) . '</span> %title' );
					next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'padpressed' ) . '</span>' );
					$truncate_title = false;
				?>
				</div>
			</div>
		<?php endif ?>
	</div>
<?php if (!$is_ajax): ?>
</section>
<?php endif ?>