<?php
/*
Plugin Name: Add Post Footer
Plugin URI: http://www.freetimefoto.com/add_post_footer_plugin_wordpress
Description: Automatically add the <b>ad code</b>, <b>related post</b>, <b>optional custom paragraph</b> or <b>technorati tags</b> to the end of every posts. All options can be fully customized though <a href="options-general.php?page=add_post_footer.php">Add Post Footer tab</a> in the option panel within wordpress admin. It's also possible overide the setting for specific post by adding custom field key and value. Please refer to the tips and addtional info provided at the <a href="http://www.freetimefoto.com/add_post_footer_plugin_manual">Add Post Footer Page</a>.
Version: 1.1
Date: November 18th, 2008
Author: freetime
Author URI: http://www.freetimefoto.com
Contributors: 
*/ 

/*	(C)Copyright, 2008  Chaiyot Kosuwanpipat  (contact: http://www.freetimefoto.com/contact)
	
	This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/
//	The apf_add_tags function are improved version of SimpleTags Plugin by Broobles (http://www.broobles.com/scripts/simpletags/)

// Admin Panel
function apf_add_pages() {
	add_options_page('Post Footer Options', 'Post Footer', 9, __FILE__, 'apf_options_page');
}

function apf_show_info_msg($msg) {
	echo '<div id="message" class="updated fade"><p>' . $msg . '</p></div>';
}

function apf_options_page() {
	if (isset($_POST['info_update'])) {
	
	$options = array(
		"apf_set_order" => $_POST["apf_set_order"],
		"apf_add_ad_code" => $_POST["apf_add_ad_code"],
		"apf_ad_code" => $_POST["apf_ad_code"],
		"apf_add_relpost" => $_POST["apf_add_relpost"],
		"apf_relpost_title" => $_POST["apf_relpost_title"],
		"apf_relpost_no" => $_POST["apf_relpost_no"],
		"apf_optional_txt" => $_POST["apf_optional_txt"],
		"apf_add_tag" => $_POST["apf_add_tag"],
		"apf_tag_label" => $_POST["apf_tag_label"],
		"apf_show_all" => $_POST["apf_show_all"],
		"apf_add_credit" => $_POST["apf_add_credit"],
		);

	update_option("add_post_footer_opts", $options);
	apf_show_info_msg("Add-Post-Footer options saved.");

	} elseif (isset($_POST["info_reset"])) {

		delete_option("add_post_footer_opts");
		apf_show_info_msg("Add-Post-Footer options deleted from the WordPress database.");

	} else {

		$options = get_option("add_post_footer_opts");

	}
	// Configuration Page
	_e('
	<div class="wrap">
		<h1>Add-Post-Footer</h1>
		<p>This is where you can configure the Add-Post-Footer plugin to add <b>Technorati Tags</b>, <b>Related Post List</b>, <b>Sponsor Paragraph</b> or even <b>Advertisement Script</b> to the end of your post.<br /><br />
		If you love this plugin and found it useful please make some donation using button above. This small donation will be fund for us to develop and improve this plugin. If you find any difficulty, any questions , suggestion or bug when use this plugin please feel free to share with us at <a href="http://www.freetimefoto.com/add_post_footer_plugin_wordpress">Add-Post-Footer page</a>.
<div align="left">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----MIIHVwYJKoZIhvcNAQcEoIIHSDCCB0QCAQExggEwMIIBLAIBADCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwDQYJKoZIhvcNAQEBBQAEgYBggpbskraX0QokgopR+VFU74h99qrOyPGW69LRJk4y7XqH161K+W27vkmV6nRCNNFhum+qeCfkFQ/6GLjoTYS4yRaUFCpCgGEfeHyY4g5TJI0+Wz2d5XqgYxl56FF80iM3JyrQSegI5/QmYGuvfifGkvfJymhO47KVGDnNYLLp2DELMAkGBSsOAwIaBQAwgdQGCSqGSIb3DQEHATAUBggqhkiG9w0DBwQI47Dgyv5XiZCAgbB+v7eQFCrLEVs8MpURDoaPBiWh6kIsLFBpA6XnoZTwQB0QaCZZcA86Duxc8UXJZRxvC7ghVxucn7Z0wct4IwNC/n4ev52CCckWiTmp95+oxW3zjN0u02S9ewlzDDJ4TuWYvml4ekQzKvuKQAff+qwHhmuGAlG55j/YVubWHd2rrMDVQPMVMdxO5+4WzyLh3uPjzVkSdVc/i/EH+3PK1aXI4P4bl7fAfEG/cEEIb96WsqCCA4cwggODMIIC7KADAgECAgEAMA0GCSqGSIb3DQEBBQUAMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTAeFw0wNDAyMTMxMDEzMTVaFw0zNTAyMTMxMDEzMTVaMIGOMQswCQYDVQQGEwJVUzELMAkGA1UECBMCQ0ExFjAUBgNVBAcTDU1vdW50YWluIFZpZXcxFDASBgNVBAoTC1BheVBhbCBJbmMuMRMwEQYDVQQLFApsaXZlX2NlcnRzMREwDwYDVQQDFAhsaXZlX2FwaTEcMBoGCSqGSIb3DQEJARYNcmVAcGF5cGFsLmNvbTCBnzANBgkqhkiG9w0BAQEFAAOBjQAwgYkCgYEAwUdO3fxEzEtcnI7ZKZL412XvZPugoni7i7D7prCe0AtaHTc97CYgm7NsAtJyxNLixmhLV8pyIEaiHXWAh8fPKW+R017+EmXrr9EaquPmsVvTywAAE1PMNOKqo2kl4Gxiz9zZqIajOm1fZGWcGS0f5JQ2kBqNbvbg2/Za+GJ/qwUCAwEAAaOB7jCB6zAdBgNVHQ4EFgQUlp98u8ZvF71ZP1LXChvsENZklGswgbsGA1UdIwSBszCBsIAUlp98u8ZvF71ZP1LXChvsENZklGuhgZSkgZEwgY4xCzAJBgNVBAYTAlVTMQswCQYDVQQIEwJDQTEWMBQGA1UEBxMNTW91bnRhaW4gVmlldzEUMBIGA1UEChMLUGF5UGFsIEluYy4xEzARBgNVBAsUCmxpdmVfY2VydHMxETAPBgNVBAMUCGxpdmVfYXBpMRwwGgYJKoZIhvcNAQkBFg1yZUBwYXlwYWwuY29tggEAMAwGA1UdEwQFMAMBAf8wDQYJKoZIhvcNAQEFBQADgYEAgV86VpqAWuXvX6Oro4qJ1tYVIT5DgWpE692Ag422H7yRIr/9j/iKG4Thia/Oflx4TdL+IFJBAyPK9v6zZNZtBgPBynXb048hsP16l2vi0k5Q2JKiPDsEfBhGI+HnxLXEaUWAcVfCsQFvd2A1sxRr67ip5y2wwBelUecP3AjJ+YcxggGaMIIBlgIBATCBlDCBjjELMAkGA1UEBhMCVVMxCzAJBgNVBAgTAkNBMRYwFAYDVQQHEw1Nb3VudGFpbiBWaWV3MRQwEgYDVQQKEwtQYXlQYWwgSW5jLjETMBEGA1UECxQKbGl2ZV9jZXJ0czERMA8GA1UEAxQIbGl2ZV9hcGkxHDAaBgkqhkiG9w0BCQEWDXJlQHBheXBhbC5jb20CAQAwCQYFKw4DAhoFAKBdMBgGCSqGSIb3DQEJAzELBgkqhkiG9w0BBwEwHAYJKoZIhvcNAQkFMQ8XDTA4MDIyNzEzMTAwMlowIwYJKoZIhvcNAQkEMRYEFJ+ZNw3CHs1pzD4vSPGKm30yT3/TMA0GCSqGSIb3DQEBAQUABIGAV+MYaZyrPJW3BPgiyBrQz8qQZDeLmSWi7hAh/fTnRFfmy1b+vRMgmn+XDZUykn0f9WQViBuhweCwWUtJ0xV90e1x1BANDrQd0gHKsaZIm7xXyD81iOaPOkU8AN/dkyiheHdcKVx472hhBC5nuu9TOIfVit9wlYBpvTrTT80pU+4=-----END PKCS7-----
">
</form>
</div></p>
		
	</div>
	<div class="wrap">
		<h1>Configuration</h1>

		<form name="formapf" method="post" action="' . $_SERVER['REQUEST_URI'] . '">
			<fieldset class="options">
				<legend><h2>Ad Code:</h2> <br />
					<p>Copy and paste your ad code provided from your ad network in text area below to show the ad at the end of every posts. It\'s also possible to override the ad showing in some posts, force ad to show or enter special ad for particular post by using custom field. <a href="http://www.freetimefoto.com/add_post_footer_plugin_manual#ad_code">more info</a></p>
					<p><b>Add Ad before Related Post: <font color="red">'. $options["apf_set_order"] . '</font></b>&nbsp;
					<select name="apf_set_order" id="apf_set_order" value="' . $options["apf_set_order"] .'">
						<option value="'. $options["apf_set_order"] .'">
						<option value="Yes">Yes
						<option value="No">No
					</select>
					If "No" Related Post List will show before Ad.
					<br/>
					<p><b>Add following Ad. code to the end of post: <font color="red">'. $options["apf_add_ad_code"] . '</font></b>&nbsp;
					<select name="apf_add_ad_code" id="apf_add_ad_code" value="' . $options["apf_add_ad_code"] .'" selected="'. $options["apf_add_ad_code"] .'">
						<option value="'. $options["apf_add_ad_code"] .'">
						<option value="Yes">Yes
						<option value="No">No
					</select>
					<br/><br/>
					<b>Ad Code Script:</b><br/>
					<textarea name="apf_ad_code" id="apf_ad_code" cols="20" rows="10" style="width: 80%; font-size: 14px;" class="code">' . stripslashes($options["apf_ad_code"]) . '</textarea></p>
				</legend>
			</fieldset>
			
			<fieldset class="options">
				<legend><h2>Related Post List:</h2><br />
					<p>Turn on this option will show related post by post category to the end of the post. You can also customize the header (default is "Related Articles:") and also maximum post to show in the list (Default is 5).</p>
					<p>To override the post showing for particular post, use custom field <b>Key: <em>apf_relate_post</em></b> and value <b>0</b>&nbsp;(force to hide post list) or <b>1</b>&nbsp;(show post list).</p>
					<p>You can customize style of post list by adding <b>"#apf_post_footer"</b> and <b>"li.apf_post_footer"</b> to your main CSS file. <a href="http://www.freetimefoto.com/add_post_footer_plugin_manual#relate_post">more info</a></p>
					<p>
					<b>Add related post list: <font color="red">'. $options["apf_add_relpost"] . '</font></b>&nbsp;
					<select name="apf_add_relpost" id="apf_add_relpost" value="' . $options["apf_add_relpost"] .'">
						<option value="'. $options["apf_add_relpost"] .'">
						<option value="Yes">Yes
						<option value="No">No
					</select>
					<br/><br/>
					<b>Maximum number of post in the list:</b> <input type="text" name="apf_relpost_no" id="apf_relpost_no" cols="20" rows="10" style="width: 10%; font-size: 14px;" class="code" value="' .$options["apf_relpost_no"] . ' "> default is 5 posts.
					<br/><br/>
					<b>The header text for post list:</b> <input type="text" name="apf_relpost_title" id="apf_relpost_title" cols="20" rows="10" style="width: 30%; font-size: 14px;" class="code" value="' . $options["apf_relpost_title"] . ' "> for example ("Related Articles:").
					</p>
				</legend>
			</fieldset>
			
			<fieldset class="options">
				<legend><h2>Optional Text:</h2><br />
					<p>Insert option text or html code to the end of the post (for example credit or sponsor link). This section will place just before technorati tags. Use custom field <b>Key: "apf_option_txt"</b> to add custom paragraph to particular post. <a href="http://www.freetimefoto.com/add_post_footer_plugin_manual#option_text">more info</a></p>
					<textarea name="apf_optional_txt" id="apf_optional_txt" cols="20" rows="10" style="width: 80%; font-size: 14px;" class="code">' . stripslashes($options["apf_optional_txt"]) . '</textarea></p>
				</legend>
			</fieldset>
			
			<fieldset class="options">
				<legend><h2>Technorati Tags:</h2><br />
					<p>Turn on this option to create a list of Technorati tags just like <a href="http://www.broobles.com/scripts/simpletags/">SimpleTags</a> plugin. The tag will retrieve from word that surrounded by [tag] or [tags] tags in each post. You can customize style of tag list by adding <b>.simpletags</b> class in your main CSS file.</p>
					<p>
					<b>Show Technorati Tags to the end of post: <font color="red">'. $options["apf_add_tag"] . '</font></b>&nbsp;
					<select name="apf_add_tag" id="apf_add_tag" value="' . $options["apf_add_tag"] .'">
						<option value="'. $options["apf_add_tag"] .'">
						<option value="Yes">Yes
						<option value="No">No
					</select>
					<br/><br/>
					<b>The label for the tag list:</b> <input type="text" name="apf_tag_label" id="apf_tag_label" cols="20" rows="10" style="width: 30%; font-size: 14px;" class="code" value="' .stripslashes($options["apf_tag_label"]) . ' "> for example ("&lt;b&gt;Technorati Tags: &lt;/b&gt;")
					</p>
				</legend>
			</fieldset>
			
			<fieldset class="options">
				<legend><h2>Addtional Option:</h2><br />
				<p><b>Show Footer Every Where:</b> <font color="red"><b>'. $options["apf_show_all"] . '</b></font>&nbsp;
							<select name="apf_show_all" id="apf_show_all" value="' . $options["apf_show_all"] .'">
							<option value="'. $options["apf_show_all"] .'">
							<option value="Yes">Yes
							<option value="No">No
						</select><br />
				Footer will show only in single post by default. Change this option to "Yes" to force the plug-in to show the footer every where when the post are shown. Including index page.
				</p>
				<p><b>Keep Plugin credit:</b> <font color="red"><b>'. $options["apf_add_credit"] . '</b></font>&nbsp;
							<select name="apf_add_credit" id="apf_add_credit" value="' . $options["apf_add_credit"] .'">
							<option value="'. $options["apf_add_credit"] .'">
							<option value="Yes">Yes
							<option value="No">No
						</select>
				</p>
				</legend>
			</fieldset>
			<p>Please refer to <a href="http://www.freetimefoto.com/add_post_footer_plugin_manual#custom_field">Add Post Footer Plugin page</a> for complete list of custom field key and value</p>
			<p class="submit">
				<input type="submit" name="info_update" value="Update Options &raquo;" />
			</p>

		</form>
	</div>
	<div class="wrap">
		<h1>Reset Plugin</h1>
		<form name="formapfreset" method="post" action="' . $_SERVER['REQUEST_URI'] . '">
			<p>By pressing the "Reset" button, the plugin will be reset. This means that the stored options will be deleted from the WordPress database. Although it is not necessary, you should consider doing this before uninstalling the plugin, so no trace is left behind.</p>
			<p class="submit">
				<input type="submit" name="info_reset" value="Reset Options" />
			</p>
		</from>
	</div>

	');

}
function apf_get_option($option_name) {
	$option_name = stripslashes($option_name);
	$option_name = trim($option_name);
	return $option_name;
}

function apf_add_tags($taged_text) {
	$options = get_option("add_post_footer_opts");
	$apf_tag_label = $options["apf_tag_label"];
   	if (empty($apf_tag_label)){
			$pre_replacement = '<div class="simpletags">';
		} else {
			$pre_replacement = '<div class="simpletags">' . apf_get_option($apf_tag_label);
		}
		$post_replacement = '</div>';
	$tag_url = "http://technorati.com/tag/";
    $tag_pattern = '/(\[tag\](.*?)\[\/tag\])/i';
    $tags_pattern = '/((?:<p>)?\s*\[tags\](.*?)\[\/tags\]\s*(?:<\/p>)?)/i'; 
    $tags_count = 0;       
    $taglist_exists = 0; 
    
    # Check for in-post [tag] [/tag]
    if (preg_match_all ($tag_pattern, $taged_text, $matches)) {
        unset($technotags);
        $technotags = $pre_replacement;
        for ($m=0; $m<count($matches[0]); $m++) {
            unset($ttags);
            $ttags = explode(",", $matches[2][$m]);
            for ($i=0; $i<count($ttags); $i++) {
                $technotags .= '<a href="' . $tag_url . urlencode(trim($ttags[$i])) . '" rel="tag">' . trim($ttags[$i]) . '</a>';
                if ($i<count($ttags)-1) {$technotags.= ", "; }
                $tags_count += 1;
            }
            $taged_text = str_replace($matches[0][$m],$matches[2][$m],$taged_text);
            if ($m<count($matches[0])-1) {$technotags.= ", "; }
        } 
    }
    
    # Check for [tags] [/tags]
    if (preg_match ($tags_pattern, $taged_text, $matches)) {
        $taglist_exists = 1;
        if ($tags_count==0) { 
            $technotags = $pre_replacement; 
        } else { 
            $technotags .= ", "; 
        }
        
        unset($ttags);
        $ttags = explode(",", $matches[2]);
        for ($i=0; $i<count($ttags); $i++) {
            $technotags .= '<a href="' . $tag_url . urlencode(trim($ttags[$i])) . '" rel="tag">' . $ttags[$i] . '</a>';
            if ($i<count($ttags)-1) { $technotags .= ", "; }
            $tags_count += 1;
        }
    }
    
    if ($tags_count>0) {
        $technotags .= $post_replacement;
        if ($taglist_exists == 1) { 
            $taged_text = preg_replace($tags_pattern,'',$taged_text); 
        } 
        $taged_text .= $technotags;
    }
    
    return $taged_text;
}
//=====================
function apff_get_posts($args) {
	global $wpdb;

	$defaults = array(
		'numberposts' => 5, 'offset' => 0,
		'category' => 0, 'orderby' => 'post_date',
		'order' => 'DESC', 'include' => '',
		'exclude' => '', 'meta_key' => '',
		'meta_value' =>'', 'post_type' => 'post',
		'post_status' => 'publish', 'post_parent' => 0
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$post_id = (int) $post_id;

	$query  = "SELECT DISTINCT * FROM $wpdb->posts ";
	$query .= empty( $category ) ? '' : ", $wpdb->term_relationships, $wpdb->term_taxonomy  ";
	$query .= empty( $meta_key ) ? '' : ", $wpdb->postmeta ";
	$query .= " WHERE 1=1 ";
	$query .= empty( $post_type ) ? '' : "AND ID = '$post_id' ";
	$query .= empty( $meta_key ) | empty($meta_value)  ? '' : " AND ($wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->postmeta.meta_key = '$meta_key' AND $wpdb->postmeta.meta_value = '$meta_value' )";
	$query .= " GROUP BY $wpdb->posts.ID ORDER BY " . $orderby . ' ' . $order;
	if ( 0 < $numberposts )
		$query .= " LIMIT " . $offset . ',' . $numberposts;

	$posts = $wpdb->get_results($query);

	update_post_caches($posts);

	return $posts;
}
//=========================
function apf_get_relate_post($apf_dis_id){
	global $category, $post;
	
	$options = get_option("add_post_footer_opts");
	$apf_relpost_txt = trim($options["apf_relpost_title"]);
	$apf_relpost_no = trim($options["apf_relpost_no"]);
	//Add header and <div>
	if (empty($apf_relpost_txt)) {
		$apf_relpost_txt = '<div id="apf_post_footer"><h4>Related Articles:</h4>'. PHP_EOL .'<ul>';
	}else{
		$apf_relpost_txt = '<div id="apf_post_footer"><h4>' . trim($options["apf_relpost_title"]) . '</h4>'. PHP_EOL .'<ul>';
	}
	//Assign Max. Post
	if (empty($apf_relpost_no)) $apf_relpost_no = '5';
	//Get category list
	foreach((get_the_category()) as $category) { 
		$apf_catid .= '&category=' . $category->cat_ID;
	} 
	//Query Post
	$apf_myposts = get_posts('numberposts=' . $apf_relpost_no .  $apf_catid . '&orderby=post_date');
	
	//Assign posts to list
	foreach($apf_myposts as $post) :
	setup_postdata($post);
	 	$apf_list_post_id = $post->ID;
		if ($apf_dis_id != $apf_list_post_id) {
			$apf_list_post_title = $post->post_title;
			$apf_list_post_link = $post->guid;
			$apf_relpost_txt .= '<li class="apf_footer"><a href="'. $apf_list_post_link .'">' . $apf_list_post_title . '</a></li>';
		}
	endforeach;
//Point back to current post
	$apf_dis_id = intval($apf_dis_id);
	$apf_myposts = apff_get_posts('post_id='.$apf_dis_id);
	foreach($apf_myposts as $post) :
	setup_postdata($post);
	endforeach;
//===========================
	$apf_relpost_txt .= '';
	//close list and div
	$apf_relpost_txt .= '</ul></div>';
	// kill variable
	unset($apf_catid, $apf_myposts);
	return $apf_relpost_txt;
}

function apf_ad_code() {
	global $posts;
	$options = get_option("add_post_footer_opts");
	$apf_add_ad_code = $options["apf_add_ad_code"];
	//add ad code
	if ($apf_add_ad_code != 'No'){
		$apf_cusfld_ad_code = get_post_meta($posts[0]->ID, 'apf_ad_code' , true);
		if ($apf_cusfld_ad_code == '0'){
			$apf_ad_code = '';
		}elseif (!empty($apf_cusfld_ad_code)){
			$apf_ad_code = '<p>'. $apf_cusfld_ad_code . '</p>';
		}else{
			$apf_ad_code = '<p>'. $options["apf_ad_code"] . '</p>';
		}
		if (!empty($apf_ad_code)) $apf_ad_code = apf_get_option($apf_ad_code);
		
	}
	return $apf_ad_code;
}

function apf_rel_post(){
	global $posts;
	$options = get_option("add_post_footer_opts");
	//add related posts
	$apf_add_relpost = $options["apf_add_relpost"];
	$apf_cusfld_relpost = trim(get_post_meta($posts[0]->ID, 'apf_relate_post' , true));
	if (($apf_add_relpost != 'No') || ($apf_cusfld_relpost == '1')){
		if ($apf_cusfld_relpost != '0') {
			$apf_rel_post = apf_get_relate_post($posts[0]->ID);
		}
	}
	return $apf_rel_post;
}
function add_post_footer($text) {
	global $posts;
	//get apf options.
	$options = get_option("add_post_footer_opts");
	$apf_show_all = $options["apf_show_all"];
	if (is_single() || ($apf_show_all == 'Yes')){
		$apf_set_order = $options["apf_set_order"];
		if ($apf_set_order == 'Yes'){
			$text .= apf_ad_code();
			$text .= apf_rel_post();
		} else {
			$text .= apf_rel_post();
			$text .= apf_ad_code();
		}
		//add optional text
		$apf_optional_txt = $options["apf_optional_txt"];
		$apf_cusfld_option_txt = get_post_meta($posts[0]->ID, 'apf_option_txt' , true);
		if ($apf_cusfld_option_txt != '0'){
			if (empty($apf_cusfld_option_txt)){
				if (!empty($apf_optional_txt)) $text .= apf_get_option($apf_optional_txt);
			}else{
				$text .= $apf_cusfld_option_txt;
			}
		}
	}
	//add simple tags
	$apf_add_tag = $options["apf_add_tag"];
	if ($apf_add_tag != 'No'){
		$text = apf_add_tags($text);
	}
	$apf_add_credit = $options["apf_add_credit"];
	if ($apf_add_credit != 'No'){
		$text .= '<p><font color="#B4B4B4" size="-2">Post Footer automatically generated by <a href="http://www.freetimefoto.com/add_post_footer_plugin_wordpress" style="color: #B4B4B4; text-decoration:underline;">Add Post Footer Plugin</a> for wordpress.</font></p>';
	}
	return $text;
	
}

add_action('admin_menu', 'apf_add_pages');
add_action('the_content', 'add_post_footer',0);

?>
