<?php global $t; ?>
<div class="home-entry">
	<?php $t->postImage(230,230);?>
	<div class="home-title">
		<a href="<?php the_permalink() ?>" class="content-grid-title"><?php the_title(); ?></a>
	</div>
	<div class="entry-content">
		<header>
			<h1><?php the_title(); ?></h1>
		</header>
		<div class="entry-body">
			<?php 
			global $more;    // Declare global $more (before the loop).
			$more = 1;       // Set (inside the loop) to display content above the more tag.
			the_content(); 
			?>
		</div>
	</div>
</div>