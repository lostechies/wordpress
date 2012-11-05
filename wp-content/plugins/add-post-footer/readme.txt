=== Add Post Footer ===
Contributors: freetime
Donate link: http://www.freetimefoto.com/add_post_footer_plugin_wordpress
Tags: post footer, advertisment, related post, tags
Requires at least: 2.0.2
Tested up to: 2.6.3
Stable tag: 1.1

Add Post Footer automatically add any custom paragraph, html code, ad code, technorati tags and/or related links list to the end of every posts.

== Description ==

Add Post Footer Plugin is very flexible and easy to use. The global options can be customized via wordpress admin option panel. Moreover the global options can override by adding special custom field to each post you want to customize its configuration individually. This will allow you to disable the appearance of some option or even add special code or paragraph for particular post. Please refer to instruction below in this page for detailed instruction.
Add Post Footer Plugin also embedded with improved [SimpleTags plugin](http://www.broobles.com/scripts/simpletags/), originally developed by Broobles, that can retrieve the tag that mark by [tag] and [tags] tag from the post any automatically generate tag list at the end of the post. The improved SimpleTags function in Add Post Footer Plugin also allow you to easily customized Technorati tags list label via wp-admin.
Please refer to the tips and addtional info provided at the [Add Post Footer Page](http://www.freetimefoto.com/add_post_footer_plugin_manual).

== Installation ==

   1. Unpack file package using your favorite zip software.
   2. Upload .php file to your wordpress plugin directory on your server.
   3. Login to wordpress admin and go to plugin tab and activate Add Post Footer Plugin.
   4. Go to Option => Add Post Footer tab to config the plugin option.

For SimpleTags user: You have to disable the original SimpleTags Plugin in order to show Technorati tags at the nd of the post. Otherwise the tag list will appear before Add footer section.

== Upgrade ==

Upgrade Add Post Footer is easy, just replace plugin file (add_post_footer.php) in plugin directory with new version. No need to re-config any options in "Post Footer" option tab. 

== Add Post Footer Plugin Configuration Panel ==

You can config the default appearance of your post footer generate by Add Post Footer Plugin in the option tab in your wp-admin (wp-admin => option => Post Footer).

###Ad. Code:

This section will allow you config the appearance of your ad from any ad network. The plugin are originally design for Chitika RPU ad, because it's easily to blended in with the post. But it also compatible with any other leading ad network script such as google adsense or widgetbucks. Just copy and paste your ad code to Ad code text area to define the default ad code. It's also possible to add any other text paragraph, html code or java script to this section.
All the options in each post can be override by adding special custom field **key: apf_ad_code** and use following value.

    * Value = 0: to turn off the ad for that post.
    * Value = 1: to turn on the ad, even if the option is turn off in config page.
    * Value = "Any Text or Code": this will add the text or code you enter in value field instead of the ad code you enter in config page.

(Please refer to Custom Field section below for detailed instruction).

**Ad Code: Options**

    * Add Ad before Related Post: The default value is "Yes", the Ad code will show as first block when Add Post Footer generate the footer. If you select "No" the Related Articles List will appear first and then your ad code.
    * Add following Ad. code to the end of post: The default value is "Yes", the Ad code will show in every post. Select "No" if you want to turn off the ad. You can also override this option for particular post by adding special custom field key: apf_ad_code and Value: 0 to turn off the ad or 1 to turn on .
    * Ad Code Script: The default ad code for every post. You can add special code for the post by using custom field key: apf_ad_code and enter your custom ad code in value field.

###Related Post List:

The Add Post Footer plugin can query related post and generate to the list to appear at the end of the post. Add Post Footer plugin will query recent post by post category. and listed it under the header you define. You can also specify maximum post that will be show in the list in this section.
To omitted the relates post list to show by adding custom field **key: "apf_relate_post"** and **Value: 0**. Or enter **Value: 1** to force related post list to show if it been turning off in config page.
You can also customize style of the related post list adding **"#apf_post_footer"** and **"li.apf_post_footer"** to your main CSS file. Please refer to example css file (apf.css) that include in download package.

**Related Post List: Options**

    * Add related post list: Default is "Yes". Change to "No" if you do not want to show related post list.
    * Maximum number of post in the list: The maximum number of posts allowed to shoe it the list. The default value is 5 posts.
    * The header text for post list: Enter the header for the related post list. This text will be between <h4> tag. If you didn't enter anything, the default label ("Related Articles:") will be use as header.

###Optional Text:

This section is similar to ad code section, you can add any text paragraph, html code or script (for example sponsor paragraph or credit) . This section will appear just before technorati tag.
You can also add special text for particular post by enter your paragraph to value field of custom field key: "apf_option_txt". This section is completely optional you can leave it blank to turn it off. And use custom field describe above to add the text to some post you need.

###Technorati Tags:

This option is improved version of SimpleTags plugin, originally developed by Broobles. If it turn on it will add tag list at the end of the post. The tags is retrieve form the post by using [tag] and [tags] tag. Please refer to [SimpleTags plugin page](http://www.broobles.com/scripts/simpletags/) for detailed instruction of adding tag to your post.
The Add Post Footer plugin is fully compatible with original SimpleTags plugin. We have add admin page that allow you to define label for your tag list and also option to turn it off. You can also add class simpletags (.simpletags) in your style sheet t style your tag list. The example of css are already include in apf.css found in download package.

**Know issue for SimpleTags User:** The SimpleTags user may need to deactivate original SimpleTags and use SimpleTags function in Add Post Footer plugin instead, in order to place the tag list appear as last section in the post. If both plugin are activate the Technorati Tags list will appear before Add Post Footer section.

**Technorati Tags: Options**

    * Show Technorati Tags to the end of post:  Default is "Yes". Change to "No" if you do not want to show Technorati Tags list.
    * The label for the tag list: Enter label for the tag list. You can use <b> or <em> tag to style your label (for example "<b>Technorati Tags: </b>". The default value is "blank". If you didn't enter any thing only tag list will appear without label.

###Addtional Option:

**Show Footer Every Where**
Change this option to "Yes" to force the plug-in to show the footer everywhere the posts are call. Otherwise they will show only in single post (default). 
Please use this option with caution. Showing the post with footer in index page may not display correctly. This will depend on your wordpress theme you are using.



###Custom Field:

Add Post Footer Plugin use several special custom field to override the plugin setting for each post. You can add custom field to the post in Write/Edit Post page in wordpress admin. You will find custom field just below trackback section in the page. Please refer to wordpress codex: using custom field for detailed instruction on adding post's custom field. Please not that you can use more than 1 key with only 1 value for each key in each post.

	**Key:** apf_ad_code **Value:** 0 	
	force to not showing "Ad code" section for specific post.

	**Key:** apf_ad_code **Value:** 1 	
	force to show Ad code for specific post even the "Add following Ad. code to the end of post:" option in config page is "No".

	**Key:** apf_ad_code **Value:** Text or HTML code 	
	Replace the ad code by value you enter in "Value" field

	**Key:** apf_relate_post **Value:** 0 	
	force to not showing the "Related Post link" for specific post.

	**Key:** apf_relate_post **Value:** 1 	
	force to showing the "Related Post link" for specific post. even the "Add related post list:" option in config page is "No".

	**Key:** apf_option_txt **Value:** Text or HTML code 	
	Add optional text or html code to specific post. Add Post Footer plugin will use text or html code in value field to show in the post. This option will work even you leave the optional text in config page blank.

###License

This project is released under the terms of the GNU GENERAL PUBLIC LICENSE

###Change Log:
    * Version 1.1 (18/11/2008) 
	- Add function to force the footer to show every where the post are call (show only in single post in previous version).
	- Revise admin page format for wordpress 2.5 and later
    * Version 1.0.1 (14/04/2008) 
	- Bug Fix for Related Post Function
    * Version 1.0 (28/02/2008) - Initial release
    

Please refer to the tips and addtional info provided at the [Add Post Footer Page](http://www.freetimefoto.com/add_post_footer_plugin_wordpress).
