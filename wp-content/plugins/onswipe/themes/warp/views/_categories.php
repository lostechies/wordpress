<?php global $t,$Options; ?>

<section id="contents">
	<?php
	$header_class = 'section-header';
	$logo_url = thumbgen($Options->get('padpress_warp','logo'),160,160);	
	$grid = $Options->get('padpress_warp','cat_grid_type');
	$grid_count = eval(str_replace('by','*',"return ".$grid.";")); // get the total count of items
	if (str_contains('void.gif',$logo_url)) {
		$header_class .= " no-image";
	}else{
	?>
	<div id="contents-logo">
		<img src="<?php echo $logo_url; ?>">
		<span>&nbsp</span>		
	</div>		
	<?php
	}
	?>
	
	<header class="<?php echo $header_class ?>">
		<?php echo size_labeled_tag(get_bloginfo('name'),'h1') ?>
		<?php echo size_labeled_tag(get_bloginfo('description'),'h2') ?>
	</header>
	<div class="grid grid_<?php echo $grid ?>">
		<?php
			$count = 0;
			$category_ids = $Options->filter('padpress_warp','contents_cat_');
			// we got the categories sorted by id not in the order the user selected it
			$unsorted = get_categories(array('include'=>$category_ids));	
			$categories = array();			

			if (is_array($category_ids)) {
				// so this loop sorts it according to the admin order.
				foreach ($category_ids as $_id) {
					if ($_id == "-1") {
						$categories[] = (object)array(
							'term_id'=>-1,
							'name'=>__('All Categories','padpressed')
						);
					}
					foreach ($unsorted as &$c) {
						if ($c->term_id == $_id) {
							$categories[] = $c;
							unset($c);
						}
					}
				}			
			}else{
				$categories = $unsorted;
			}

			
			foreach ($categories as $category) {
			$count++;
			?>
				<div class="grid-item" <?php echo element_data(array('type'=>'category','term'=>$category->term_id)) ?>>
					<header>
						<h1>
							<a class="section-link" href="#">
								<?php echo $category->name ?>
							</a>						
						</h1>						
					</header>
				</div>
			<?php
			if ($count == $grid_count) break;
			}	
		?>		
	</div>
	
	<?php optout_link(__('Return to the regular version')); ?>
	
	<div id="copyright" class="PopOver">
		<header><h1><?php _e('Pages') ?></h1></header>
		<div class="body">
			<nav><ul>
				<?php wp_list_pages(array(
					'title_li'=>'',
					'depth'=>1
				)); ?>
			</ul></nav>
		</div>
		<p class="stem"></p>
	</div>
	
</section>