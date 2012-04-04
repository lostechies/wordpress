=== Plugin Name ===
Contributors: ephramzerb
Donate link: http://ephramzerb.com/
Tags: rss, feeds, feed, redirect, atom, feedburner
Requires at least: 2.5
Tested up to: 3.0.1
Stable tag: 0.3.2

FeedWrangler is a utility for creating and editing custom feeds.

== Description ==

Feed Wrangler is a simple plugin that allows one to create custom feeds for their WordPress blog. You can customize the structure of that feed by creating a corresponding file in your blog theme, otherwise the custom feed will default to your RSS2 feed.

Some possible use cases for the plugin:

* You want a custom URL to access a feed by (i.e. "/feed/misterspecialfeed" )
* You want some feeds to bypass Feedburner redirect.
* A sponsor asks you to place an ad in your feed
* You need a clean, ad-free feed to provide a partner (see Amazon Kindle), that doesn't go through FeedBurner or is customized in any way.
* You prefer adding and editing feeds in a way more analogous to Movable Type


== Installation ==

1. Upload the `feed-wrangler` directory to your blog's `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to "Settings" > "Feed Wrangler" to create a new feed.

You can also install through your Wordpress admin by going to "Plugins" > "Add New" and searching for "Feed Wrangler"

== Screenshots ==

1. Main settings screen where you can add feeds, see feeds you've created and delete feeds

== Frequently Asked Questions ==

= What happens when a feed slug conflicts with an existing permalink? =

The feed will take precedence.

= I want to make a feed only slightly different from an RSS2 feed, where do I start? =

Once you create a new feed in the Feed Wrangler interface, you can create a corresponding template file in your current theme to customize your newly created feed.  The admin interface will tell you the file name to use.

If you want to start off with one of the default templates -- let's say RSS2 -- just copy and paste the code from `/wp-includes/feed-rss2.php` (`/wp-includes/wp-rss2.php` in older versions of Wordpress) into the new theme file and make the changes and additions you see fit.

= What's a good way to test feed template changes? =

On a Mac, I like using Firefox with the "Feeds" option set to "Show me a preview and ask me which Feed Reader to use".  When you access your feed in Firefox, you have to clear the cache as you reload (COMMAND + SHIFT + R) -- otherwise you might have trouble seeing your changes.  Viewing the source of that preview page will give you the raw feed source.  Once the source looks fine, it's a good idea to drop the feed in an actual feed reader and see how it responds.  Also, don't forget about [Feed Validator](http://feedvalidator.org// "Feed Validator for Atom and RSS").

= Upgrading to Wordpress 2.6 deletes all my feeds  = 

If you're using version .1 of Feed Wrangler, you'll need to upgrade Feed Wrangler BEFORE upgrading your Wordpress to 2.6.

