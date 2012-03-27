=== Plugin Name ===
Contributors: Lucian Apostol
Donate link: http://autoaffiliatelinks.com
Tags: affiliate, links, post
Requires at least: 2.5.2
Tested up to: 3.3
Stable tag: 2.3.1

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

== Description ==

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

What you get is an administration page where you add all your affiliate links you want displayed on your blog, and where you can activate and de-activate the plugin. 

When you add a link, you need to specify keywords that will be used to match the content from your website. Whenever tht keyword is displayed, a link to the affiliate website is added.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Manage Affiliate Links' link in your Administration Panel Menu
4. Add affiliate links and keywords

== Frequently Asked Questions ==

= The plugin will modify the content in the database ? =

No, the plugin only add the links when the page is rendered. The content remain intact in your database.

= Cloacked links are not working, what should I do ? =

For now, disable cloacked links in the management page. If you want to help us to figure out the issue please send us a note. We are working to make this working for all.

= Do i have to change my theme to make the plugin work? =

No theme changes are needed for this plugin. 

= How it will affect my design and blog functionality =

The blog functionality will not be affected in any way.

== Changelog ==

= 2.3.1 =
* Added option to choose if you want to show original or cloacked links. 

= 2.3 = 
* Now all affiliate links are cloacked. Contribution of Jos Steenbergen

= 2.2.3.2 =
* Verification, reindenting and commenting the plugin code

= 2.2.3.1 = 
* Fixed some notifications to not be displayed

= 2.2.3 =
* Fixed a bug where some odd characters were added if an extra comma was added

= 2.2.2 =
* Added option to exclude specific posts or pages from displaying affiliate links, based on post ID.

= 2.2.1 =
* Fixed a bug when links were limited to 1 on post pages

= 2.2 =
* Added option to limit the number of times a keyword appear in a post

= 2.1.1 =
* Fixed some bugs from previous releases: errors generated when no keyword was set

= 2.1 =
* Added select option to choose if the links should be added on the homepage too

= 2.0 =
* Added auto-suggestions for keywords based on most used words in the content

= 0.1.9.2 =
* Made changes to the user interface for a better experience
* Added confirmation alert for delete links

= 0.1.9.1 =
* Added option to donate to support the continued development

= 0.1.9 =
* Made the link to open in a new window by default

= 0.1.8 =
* Fixed the bug when if no keyword was set, a warning message appears

= 0.1.7 =
* Revamped the replacing engine to solve the bugs and problems with the code.

= 0.1.6 =
* Changed some actions on forms to minimize the risks of collision with other plugins

= 0.1.5 =
* Fixed the bug where the apostrophe character was rendered inappropiate and displaying wrong code

= 0.1.4 =
* Added option to edit links and keywords that already exist

= 0.1.3 =
* Moved the add/delete actions to admin_init
* Added redirects for add/delete actions so if you hit refresh the same action won't be repeated

= 0.1.2 =
* Fixed the issue where all links were decapitalized.

= 0.1.1 =
* Fixed the issue where links are accidentaly break html code. 

= 0.1 =
* This is the first version of the plugin. Any suggestions and feedback is highly appreciated.