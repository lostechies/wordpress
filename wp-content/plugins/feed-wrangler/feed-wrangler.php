<?php
/*
Plugin Name: Feed Wrangler
Plugin URI: http://www.ephramzerb.com/projects/feed-wrangler
Description: A feed utility for creating custom feeds.  Useful if you need a clean feed that doesn't go through FeedBurner for example. 
Author: Ivan Kanevski
Author URI: http://www.ephramzerb.com
Version: 0.3.2
*/


class FeedWrangler {
	var $feeds = array();
	var $original_is_feed;
	
	function FeedWrangler() {
	  $stored_options = get_option('feed_wrangler_feeds');
	  $this->feeds = (is_serialized($stored_options)) ? unserialize($stored_options) : $stored_options;
		add_action('template_redirect', array(&$this, 'short_circuit_feedburner_before'), 1);
		add_action('template_redirect', array(&$this, 'short_circuit_feedburner_after'), 100);
		add_action('init', array(&$this, 'add_all_feeds'));
		add_action('admin_menu', array(&$this, 'fwik_add_navigation'));
	}
	
	function add_all_feeds($flush_db = 'false') {
	  global $wp_rewrite;
		if (!empty($this->feeds)) {
			foreach($this->feeds as $feed) {
				$this->add_feed($feed['feed_slug']);
			}
		}
		update_option('feed_wrangler_feeds', serialize($this->feeds));
		if ($flush_db) {
			$wp_rewrite->flush_rules();
		}
	}
	
	function add_feed($feed_slug) {
		$individual_feed = new FeedWranglerIndividualFeed($feed_slug);
		add_feed($feed_slug, array($individual_feed, 'load_feed'));
	}
		
	function add_new_feed($feed_slug, $feed_notes) {
		global $wpdb;
		
		// check if slug is unique
		if(!empty($this->feeds)) {
			foreach($this->feeds as $feed) {
				if ($feed['feed_slug'] == $feed_slug) {
					return false;
				}
			}
		}
		$this->feeds[] = array('feed_slug' => $feed_slug, 'feed_notes' => $feed_notes);
		$this->add_all_feeds(true);
		return true;
	}
	
	function delete_feed($feed_slug) {
		$successful_delete = false;
		foreach($this->feeds as $key => $value) {
			if ($this->feeds[$key]['feed_slug'] == $feed_slug) {
				unset($this->feeds[$key]);
				$this->add_all_feeds(true);
				$successful_delete = true;
			}
		}
		if ($successful_delete == true) {
			return true;
		} else {
			return false;
		}
	}
	
	function short_circuit_feedburner_before() {
		global $wp_query, $feed;
		$this->original_is_feed = $wp_query->is_feed;
		if (!empty($this->feeds) && $this->original_is_feed == true) {
			foreach($this->feeds as $my_feed) {
				if ($my_feed['feed_slug'] == $feed) {
					$wp_query->is_feed = false;
				}
			}
		}
	}
	
	function short_circuit_feedburner_after() {
		global $wp_query, $feed;
		$wp_query->is_feed = $this->original_is_feed;
	}
	
	function fwik_add_navigation() {
		add_options_page("Feed Wrangler", "Feed Wrangler", "manage_options", basename(__FILE__), "fwik_options_page");
	}
	
}


class FeedWranglerIndividualFeed {
	var $slug;
	
	function FeedWranglerIndividualFeed($slug) {
		$this->slug = $slug;
	}
	
	function load_feed() {
		// check if template exists in theme directory, use default RSS2 template otherwise
		if (file_exists(TEMPLATEPATH . '/feed-' . $this->slug . '.php')) {
			load_template(TEMPLATEPATH . '/feed-' . $this->slug . '.php');
		} else {
			load_template(ABSPATH . WPINC . '/feed-rss2.php');
		}
	}
	
	
	function template_to_use() {
		if (file_exists(TEMPLATEPATH . '/feed-' . $this->slug . '.php')) {
			return('feed-' . $this->slug . '.php');
		} else {
			return('default');
		}	
	}
	
}

// Generate the options page

function fwik_options_page() {
	global $feed_wrangler;

if ($_POST['feed_slug']) {
	if (check_admin_referer('feed-wrangler-update-options-add-feed')) {
		if ($feed_wrangler->add_new_feed($_POST['feed_slug'], $_POST['feed_notes'])) {
			echo <<<SUCCESSINADDING
			<div id="message" class="updated fade">
			<p>New feed created successfully.</p>
			</div>
SUCCESSINADDING;
		} else {
	echo <<<ERRORINADDING
				<div id="message" class="error fade">
				<p>Couldn't add feed. The feed slug needs to be unique for each feed.</p>
				</div>
ERRORINADDING;
		}
	}
}

if ($_GET['delete']) {
	if (check_admin_referer('feed-wrangler-delete-feed')) {
		if($feed_wrangler->delete_feed($_GET['delete'])) {
			echo <<<SUCCESSINDELETING
			<div id="message" class="updated fade">
			<p>Feed deleted successfully.</p>
			</div>
SUCCESSINDELETING;
		} else {
	echo <<<ERRORINADDING
				<div id="message" class="error fade">
				<p>Huh. Something went wrong, feed couldn't be deleted.</p>
				</div>
ERRORINADDING;
		}
	}	
}

echo <<<OPTIONS_PAGE
<div class="wrap">
<h2>Feed Wrangler Options</h2>
<h3>
Add new feed
</h3>

<form action="?page=feed-wrangler.php" method="post">
OPTIONS_PAGE;

wp_nonce_field('feed-wrangler-update-options-add-feed');

echo <<<OPTIONS_PAGE
<table class="form-table">
<tr valign="top">
	<th scope="row"><label for="feed_slug">Feed Slug</label></th>
	<td>
	<input name="feed_slug" type="text" id="feed_slug" class="regular-text code" size="20" /> <span class="description">The name by which feed will be accessible, for example: /feed/your-feed-slug</span>
	</td>
</tr>

<tr valign="top">
	<th scope="row"><label for="feed_notes">Notes</label></th>
	<td>
	<input name="feed_notes" type="text" id="feed_notes" class="regular-text" size="20" /> <span class="description">Some quick notes to remember the feed by</span>
	</td>
</tr>

</table>

<p class="submit">
<input type="submit" name="Submit" value="Add Feed" />
</p>

</form>

<h3>Current Feeds</h3>
<table class="widefat">
	<thead>
	<tr>
	<th scope="col">Slug</th>
	<th scope="col">Notes</th>
	<th scope="col">Template being used</th>
	<th scope="col">&nbsp;</th>
	</tr>
	</thead>
OPTIONS_PAGE;

if (!empty($feed_wrangler->feeds)) {
	foreach($feed_wrangler->feeds as $feed) {
		$individual_feed = new FeedWranglerIndividualFeed($feed['feed_slug']);
		print('<tr>');
		print('<th><a href="'. get_option('home') . '/?feed=' . $feed['feed_slug'] .  '">' . $feed['feed_slug'] . '</a></th><td>' . stripslashes($feed['feed_notes']) . '</td>');
		if ($individual_feed->template_to_use() == 'default') {
			print('<td>Default <span style="color: #666">(create <code>feed-' . $feed['feed_slug'] . '.php</code> in your theme to override)</span></td>');
		} else {
			print('<td style="color: green;">' . $individual_feed->template_to_use() . '</td>');
		}
		$delete_link = '?page=feed-wrangler.php&delete=' . $feed['feed_slug'];
		$delete_link = wp_nonce_url($delete_link, 'feed-wrangler-delete-feed');
		print('<td><a href="' . $delete_link . '">Delete</a></td>');
		print('</tr');
	}
}

echo <<<OPTIONS_FOOTER
</table>
</div>
OPTIONS_FOOTER;

}

$feed_wrangler = & new FeedWrangler();

?>
