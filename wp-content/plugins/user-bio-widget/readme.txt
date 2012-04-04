=== User Bio Widget ===
Tags: widget, bio, user bio, author bio, gravatar
Requires at least: 2.8
Tested up to: 3.0
Stable tag: 0.2

Easily display the "Biographical Info", and Gravatar, of any author's user profile in your blog's sidebar. Compatible with the Multi-Site functionality.

== Description ==

This widget will easily allow you to display the "Biographical Info" of any blog author's user profile in the sidebar. It allows you to choose from multiple authors/users on the blog, if your blog does, in fact, have multiple authors. Subscribers are excluded for obvious reasons (Contributors, Authors, Editors, and Administrators are included).

Additionally, the widget grants the ability to display the selected author's Gravatar, with multiple size and alignment options available.

Please submit any bug reports, support questions, or requests <a href="http://anthonybubel.com/contact">here</a>.

== Installation ==

1. Upload `user-bio-widget.php` to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins -> Installed' menu in your dashboard.
1. Add the 'User Bio' Widget to your sidebar via 'Appearance -> Widgets' in your dashboard.

== Frequently Asked Questions ==

= How can I style the Gravatar image? =

You can add and customize the following CSS within your theme's primary stylesheet/CSS file (normally style.css):

.ub-grav img {
***These are just some example properties you can use***
border: 2px solid #eeeeee;
padding: 3px;
}

= Are subscribers included? =

No. Only contributors, authors, editors, and administrators (i.e. any user able to actually create posts).

= What's a Gravatar? =

A Gravatar is a Globally Recognized Avatar (i.e. your user picture/icon). You can upload one via <a href="http://gravatar.com">http://gravatar.com</a> (it will be attached to your e-mail address).

= Can I only display my Gravatar with the widget? =

Yes; simply leave your "Biographical Info" section (in your user profile) blank, and configure the widget to display your Gravatar.

= If an author doesn't have a Gravatar uploaded, and they configure the widget to display a Gravatar, which image is used? =

The default image is determined by the 'Default Avatar' setting found in your dashboard under Settings -> Discussion.

= I have a Gravatar configured, but it's not appearing. What's up? =

For the Gravatar to appear, you must have the 'Show Avatars' option under Settings -> Discussion set to 'Show Avatars'. Also, please check your 'Maximum Rating' setting and compare it with your own Gravatar's rating.

== Changelog ==

= 0.2 =
* Adds compatibility with the WordPress 3.0 Multi-Site feature.
* Adds a configuration option for displaying only the Gravatar image (with no bio text).
* Updates the message displayed if no bio information is entered in the author's profile.
* Adds some additional styling to the "Gravatar Options" section in the widget's configuration panel.
* Slightly modifies the default styling of the Gravatar image.