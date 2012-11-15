=== Plugin Name ===
Contributors: Lucian Apostol
Donate link: http://autoaffiliatelinks.com
Tags: affiliate, links, post, plugin, posts, url, keywords, text, content, automatic
Requires at least: 2.5.2
Tested up to: 3.4.2
Stable tag: 2.8

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

== Description ==

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

You can manage your affiliate links trough an administration page, under the "Settings" menu category. You have to add affiliate links, and specify one or more keywords for each. The plugin will add them when a page is viewed. Your content won't be modified in the database. 

You will have options to make the links nofollow or dofollow, to open in new page or same page and to cloack links. The plugin will give you the most used 20 keywords from your content si you can easily add affiliate links to appear when they are displayed. 

You have the option to limit the number of links that are added to each post or page.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin to the `/wp-content/plugins/` directory or download it directly from your administration panel.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Wp Auto Affiliate Links' link, under "Settings",  in your Administration Panel Menu.
4. Add your affiliate links, along with one or more keywords. Do this for every affiliate link you want to display.
5. Select if you want your links to be nofollow, cloacked, to open in new window, and the maximum number of lniks that are added to every article. On some environments, the cloacking of the links is impossible. If you experience problems, turn the cloacking off and it should work just fine.
6. If you don't get it how to make it work, or if something goes wrong, please consult http://autoaffiliatelinks.com for more info and use the contact form on the website to report the problem or to ask for help.

== Frequently Asked Questions ==

= The plugin will modify the content in the database ? =

No, the plugin only add the links when the page is rendered. The content remain intact in your database.

= Cloacked links are not working, what should I do ? =

Link cloacking can cause problems on some environments ( shared hosting with too much restrictions ). If you experience problems please turn cloacking off.

= Do i have to change my theme to make the plugin work? =

No theme changes are needed for this plugin. 

= How it will affect my design and blog functionality ? =

The blog functionality will not be affected in any way. Links will be added in your content and they will look just like normal links. 

= How do I make links nofollow ? =

On the plugin management page: "Wp Auto Affiliate Links" under "Settings", you will have the option to set a link to have rel="nofollow" attribute.

= How do I make the links to open in new window ? =

On the plugin management page: "Wp Auto Affiliate Links" under "Settings", you will have the option to set the links to open in new or in the same window. By default, links will open in a new window. As a matter of fact, it is better for external links to open in new window, so the user will notice that he is on another website right now, and to have your website still open, if he want to read more or to visit another link.

= Can I add the same affiliate link with more keywords ? =

Yes. You can add more keywords in the same box, sepparated by comma. For example: "android,smartphone,phones". If you add the same link 3 times with different keywords the result will be the same: The link will appear for all the keywords added. 

= Can I add more links for the same keyword ? =

If you add more links with the same keyword, only the first occurence of the keyword will add the first link. If the same keyword appear again in the article, the second link will be added on it.

== Changelog ==

= 2.8 =
* Made dbDelta function to work. When the plugin is upgraded, the database tables are also upgraded. 

= 2.7.3 =
* Added uninstall file. When the plugin is uninstalled ( deleted from the plugins administration ), the database is cleaned. 

= 2.7.2 =
* Added a class attribute to every automated links, so they can have a different desing from other links, if required.

= 2.7.1 =
* Removed some reduntant code, blank lines and spaces to clean the code and make it smaller

= 2.7 =
* Fixed some minor issues and display disorders

= 2.6.1 =
* Changed description to match the latest udpates

= 2.6 =
* Modified the cloacking system to work with the latest versions of wordpress

= 2.5.1 =
* Fixed an error that generated a warning and in some configurations prevented the execution

= 2.5 = 
* Added option to make the links nofollow or dofollow

= 2.4.1 =
* Removed an error reporting issue

= 2.4 =
* Added the ability to selest do open links in same or new window.

= 2.3.3 =
* Fetching the most used 20 words instead of 10

= 2.3.2 =
* Changed the admin panel settings menu link name from Manage Affiliate Links to Wp Auto Affiliate Links to eliminate any confusion.
* Changed some function names to prevent clashes with other plugins

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