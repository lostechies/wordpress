<?php

if (!function_exists('staticize_subdomain')) {
	function staticize_subdomain( $url ) {
	    return $url;
	}
}

if (!function_exists('set_merge')) {
	/**
	 * set_merge, borrowed from he cakephp.org project. Is like array_merge, except it merges even deep arrays
	 *
	 * @param string $arr1 
	 * @param string $arr2 
	 * @return void
	 * @author Armando Sosa
	 */
	function set_merge($arr1, $arr2 = null) {
		$args = func_get_args();

		$r = (array)current($args);
		while (($arg = next($args)) !== false) {
			foreach ((array)$arg as $key => $val) {
				if (is_array($val) && isset($r[$key]) && is_array($r[$key])) {
					$r[$key] = set_merge($r[$key], $val);
				} elseif (is_int($key)) {
					$r[] = $val;
				} else {
					$r[$key] = $val;
				}
			}
		}
		return $r;
	}
}

if (!function_exists('pr')) {
	/**
	 * Helper function for development.
	 *
	 * @param string $v 
	 * @return void
	 * @author Armando Sosa
	 */
	function pr($v){
		echo "<pre>";
		print_r($v);
		echo "</pre>";
	}    
}

/**
 * Generates a thumb image url
 *
 * @param string $url, the url of the image 
 * @param string $width 
 * @param string $height 
 * @param string $crop 
 * @return void
 * @author Armando Sosa
 */
if (!function_exists('thumbgen')) {
	function thumbgen($src,$w,$h,$zc=1,$q=75,$fx=0){

		if (str_contains('gravatar',$src)) {
			return $src;
		}

		// check if this is a multisite url, 
		// if so, we are going to pass the actual url, not the fake one.
		if (is_multisite()) {
			preg_match("#([_0-9a-zA-Z-]+/)?files/(.+)#",$src,$match);

			if (isset($match[2]) && file_exists(BLOGUPLOADDIR.$match[2])) {

				$absparts = explode('wp-content',BLOGUPLOADDIR);

				if (isset($absparts[1])) {
					$src = $absparts[1] . $match[2];
				}				

			}

		}


		$url =  PADPRESS_PLUGIN_URL . '/framework/thumb/thumb.php?';
		$url.= "src=$src&w=$w&h=$h&zc=$zc&q=$q&fx=$fx";
		$url = str_replace('&','&amp;',$url);
	 	return $url;
	}
}



if (!function_exists('str_contains')) {
	function str_contains($pattern,$str){
		$p = strpos($str,$pattern);
		return ($p !== false);
	}
}
if (!function_exists('str_starts_with')) {
	function str_starts_with($pattern,$str){
		$p = strpos($str,$pattern);
		return ($p === 0);
	}
}

if (!function_exists('word_truncate')) {

	function word_truncate($string,$length = 20,$ellipsis = "&hellip;"){

		if (strlen($string) < $length) return $string;

		$string =  preg_replace("/\w+$/","",substr($string,0,$length));

		return $string . $ellipsis;
		
	}
}


/**
 * returns true if the current request has been made via ajax;
 *
 * @return void
 * @author Armando Sosa
 */
function is_ajax_request(){
	if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		return false;
	}
	
	return true;
}

/**
 * returns the previous post url
 *
 * @param string $in_same_cat 
 * @param string $excluded_categories 
 * @return void
 * @author Armando Sosa
 */
function previous_post_url($in_same_cat = false, $excluded_categories = '') {
	return adjacent_post_url($in_same_cat, $excluded_categories, true);
}

/**
 * return the next post url
 *
 * @param string $in_same_cat 
 * @param string $excluded_categories 
 * @return void
 * @author Armando Sosa
 */
function next_post_url($in_same_cat = false, $excluded_categories = '') {
	return adjacent_post_url($in_same_cat, $excluded_categories, false);
}

/**
 * returns the adjacent post url
 *
 * @param string $in_same_cat 
 * @param string $excluded_categories 
 * @param string $previous 
 * @return void
 * @author Armando Sosa
 */
function adjacent_post_url($in_same_cat = false, $excluded_categories = '', $previous = true) {

	if ( $previous && is_attachment() )
		$post = & get_post($GLOBALS['post']->post_parent);
	else
		$post = get_adjacent_post($in_same_cat, $excluded_categories, $previous);

	if ( !$post )
		return;

	$url = get_permalink($post);
	return $url;
}

/**
 * Gets an associative array and returns a html5 data attribute 
 *
 * @param string $data 
 * @return void
 * @author Armando Sosa
 */
function element_data($data = array()){
	$attr = "";
	foreach ($data as $key => $value) {
		if (!is_string($key) || empty($value)) {
			continue;
		}
		$value = esc_attr($value);
		$attr .= "data-$key = '$value' ";
	}
	return $attr;
}

/**
 * Generates a link formatted with the optout
 *
 * @param string $label 
 * @return void
 * @author Armando Sosa
 */
function optout_link($label){

	$link = get_bloginfo('url');	
	if (is_single() && is_page()) {
		$link = get_permalink();
	}
	
	$link .= "?padpressed_opt=nay";
	
	echo "<a href='$link' id='optout-link'><span>$label</span></a>";
}



/**
 * Returns relative time in spanish
 *
 * @param string $length 
 * @return void
 * @author Armando Sosa
 */

function padpressed_relative_time($date, $default = null){

	$timestamp = strtotime($date);
	$difference = time() - $timestamp;

	if($difference >= 60*60*24*7){        // if more than a week ago
		if ($default) {
			$r = $default;
		}else{
			$r = date("M d, y @ h:ma", $timestamp);
		}
	} elseif($difference >= 60*60*24){      // if more than a day ago
		$int = intval($difference / (60*60*24));
		$s = ($int > 1) ? 'days' : 'day';
		$r = sprintf(__('%1$s %2$s ago','padpressed'),$int,$s);		
		
	} elseif($difference >= 60*60){         // if more than an hour ago
		$int = intval($difference / (60*60));
		$s = ($int > 1) ? 'hours' : 'hour';
		$r = sprintf(__('%1$s %2$s ago','padpressed'),$int,$s);		
	} elseif($difference >= 60){            // if more than a minute ago
		$int = intval($difference / (60));
		$s = ($int > 1) ? 'minutes' : 'minute';
		$r = sprintf(__('%1$s %2$s ago','padpressed'),$int,$s);		
	} else {                                // if less than a minute ago
		$r = __('less than a minute ago');
	}

	return $r;
}

function hashbang_redirect(){
?>
	<script type="text/javascript" charset="utf-8">
		try{
			var id = location.hash.match(/.+entry\/(\d+)/)[1];
			if (id) {
				window.location = "<?php echo bloginfo('url') ?>?p=" + id;
			};
		}catch(error){
		}
	</script>		
<?php
}