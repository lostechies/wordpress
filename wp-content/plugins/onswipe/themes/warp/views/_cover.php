<?php global $t,$Options; ?>
<section id="cover">
	<?php
		$logo_url = $Options->get('padpress_warp','cover_logo');	
		if (str_contains('void.gif',$logo_url)) 
			$logo_url = false;
		$title = get_bloginfo('name');
		$fontsize = ceil(768 / strlen($title));
		if ($fontsize > 80) $fontsize = 80;
		if ($fontsize < 30) $fontsize = 30;
	?>
	<?php if ($logo_url): ?>
		<img id="logo" src="<?php echo $logo_url; ?>">
	<?php endif ?>

    <div class="cover-title">
    	<h1 style="font-size:<?php echo $fontsize; ?>px">
    		<?php echo $title ?>
    	</h1>        
    </div>			
	
	<?php
		$count = 0;
		if (have_posts()) while (have_posts()){
			$count ++;
			if ($count > 4 ) break;

			the_post();

			$img = $t->postImage(1024,1024,false,false);
			if ($img){
				echo $img;				
				break;
			} 

		}
	?>
	
	<div id="swipeme"><span><?php _e('swipe me','padpressed') ?></span></div>
</section>	
