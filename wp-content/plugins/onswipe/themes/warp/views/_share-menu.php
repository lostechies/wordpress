<?php
global $post;
$url = wp_get_shortlink();
if (empty($url)) {
	$url = get_permalink();
}
$url=trim($url);
$title = get_the_title();
$links = array(
	'twitter'   => "http://twitter.com/share?text=$title&url=$url",
	'facebook'  => "http://www.facebook.com/share.php?u=$url",
	'email'     => "mailto:?subject=$title&body=$url",
	'permalink' => $url,
);
?>
<div id="share-menu">
	<header>
	    <h1><?php _e('Share :','padpressed'); ?> &lsquo; <?php echo word_truncate($title,20); ?> &rsquo;</h1>
	</header>
	<div class="body">
	    <nav>
	        <ul>
	            <li>
	                <a href="<?php echo $links['twitter'] ?>" class="twitter"><?php _e('On Twitter','padpressed'); ?></a>
	                <a href="<?php echo $links['facebook'] ?>" class="facebook"><?php _e('On Facebook','padpressed'); ?></a>
	                <a href="<?php echo $links['email'] ?>" class="email"><?php _e('By E-Mail','padpressed'); ?></a>
	            </li>
	        </ul>
	    </nav>
	</div>
	<div class="info">
	    <div><?php echo $url ?></div>
	</div>
	<p class="stem"></p>	
</div>