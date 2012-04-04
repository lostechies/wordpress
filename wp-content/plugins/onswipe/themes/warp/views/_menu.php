<!--
    THE MENU
-->
<div id="menu" class="drilldown <?php echo (is_single() || is_page()) ? "single" : "" ?>">
	<header>
	    <a href="#" class="goback left back button"><?php _e('back','padpressed') ?></a>
		<h1 id="menu-title"><?php _e('Menu','padpressed') ?></h1>			
	</header>
	<?php
		$home_url = get_option( 'show_on_front', false ) === 'page' ? get_permalink(get_option('page_for_posts',false)) : get_bloginfo('url');
		$home_url = trailingslashit( $home_url ) . "#!/all";
	?>
	<div class="inner">
		<ul>
			<?php wp_list_pages(array(
				'title_li'=>'<a href="#" class="drill">'.__('Pages','padpressed').'</a>',
			)) ?>
			 <li>
				<a href="<?php echo $home_url ?>"><?php _e('All posts','padpressed') ?></a>
			 </li>            
			<?php 
				wp_list_categories(array(
				 'title_li'=>'',
				 'orderby'=>'count',
				 'order'=>'DESC',
				 'number'=>9
				)); 
			?>
		</ul>        
	</div>

	<p class="stem"></p>
</div>

<script type="text/javascript" charset="utf-8">
	$(function() {
    return $('.drilldown').drilldown();
  });
</script>
