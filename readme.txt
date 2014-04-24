=== Plugin Name ===
Contributors: Lucian Apostol
Donate link: http://autoaffiliatelinks.com
Tags: affiliate, links, post, plugin, posts, url, keywords, text, content, automatic
Requires at least: 2.5.2
Tested up to: 3.9
Stable tag: 3.10.1

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

== Description ==

Provide an interface to add your affiliate links and associate them with keywords. The affiliate links will be added to all the terms specified found in your content.

You can manage your affiliate links trough an administration page, under the "Settings" menu category. You have to add affiliate links, and specify one or more keywords for each. The plugin will add them when a page is viewed. Your content won't be modified in the database. 

You will have options to make the links nofollow or dofollow, to open in new page or same page and to cloak links. The plugin will give you the most used 20 keywords from your content si you can easily add affiliate links to appear when they are displayed. 

You have the option to limit the number of links that are added to each post or page.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin to the `/wp-content/plugins/` directory or download it directly from your administration panel.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Wp Auto Affiliate Links' link, under "Settings",  in your Administration Panel Menu.
4. Add your affiliate links, along with one or more keywords. Do this for every affiliate link you want to display.
5. Select if you want your links to be nofollow, cloaked, to open in new window, and the maximum number of lniks that are added to every article. On some environments, the cloaking of the links is impossible. If you experience problems, turn the cloaking off and it should work just fine.
6. If you don't get it how to make it work, or if something goes wrong, please consult http://autoaffiliatelinks.com for more info and use the contact form on the website to report the problem or to ask for help.

== Frequently Asked Questions ==

= The plugin will modify the content in the database ? =

No, the plugin only add the links when the page is rendered. The content remain intact in your database.

= Cloaked links are not working, what should I do ? =

Link cloaking can cause problems on some environments ( shared hosting with too much restrictions ). If you experience problems please turn cloaking off.

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

= How Clickbank links work =

First you have to request an API key from the "API Key" menu. Then, from the "Clickbank Links" menu you will have to enter your affiliate id, category and minimum gravity ( leave 0 for all links ), and set the plugin to "active". Once you do this links from clickbank will start to show on your pages.

= The plugin makes my blog to show odd html code = 

If you encounter any problem with the plugin, please contact us using the form at http://autoaffiliatelinks.com and we will help you to solve your issue. It has been reported that some lightbox plugin my be interfeering with our plugin. 

== Changelog ==

= 3.10.1 =
* Hide the advanced features if the api key is not set

= 3.10 =
* Added a new premium feature: fully automated shareasale links

= 3.9.2.2 =
* Prepared the plugin for 3.9 Wordpress update

= 3.9.1 =
* Moved the api script from wp head to wp_print_scripts

= 3.9 =
* New feature: Amazon links can be added automatically. 

= 3.8.3.3 =
* Fixed a bug that caused the api connection to fire multiple times.

= 3.8.3.2 =
* Now post url is sent to ajax

= 3.8.3.1 =
* Added notice about the recent bug fix

= 3.8.3 =
* Fixed a major bug that prevented users adding new links.

= 3.8.2.1 =
* Added value for submit affiliate links button so the browser won't translate it. 

= 3.8.2 =
* Cleaned the code generated by the plugin
* Rearranged javascript code.

= 3.8.1 =
* Removed a notice message

= 3.8 =
* Major improvements on replacement engine, site speed and keyword matching
* New functionality added: Clickbank links can be automatically extracted and displayed, based on user selection
* To reduce page load on the plugin, the clickbank link search and replacement is done on our servers
* The access to the servers is done trough an API key
* For clickbank links, the user inputs his affiliate code, prefered category and minimum gravity. All links are automatically generated, there is no need to add keywords for amazon.

= 3.7.2 =
* Reordered some code for better performance and visibility

= 3.7.1 =
* Tweaked the code for better performance
* Started to change the coding style for future development

= 3.7 =
* Added is_main_query check to prevent the plugin to process anything if it is outside of the main loop

= 3.6.9 =
* Improved significantly the processing time of the affiliate links replacement, lowering the loading speed by more than 10 times

= 3.6.8.1 =
* Renamed the main css file

= 3.6.8 =
* Completely removed the tabs user interface

= 3.6.7 =
* Now the modules add a new submenu item under Wp Auto Affiliate Links instead of a tab on the main page.

= 3.6.2.7 =
* Moved Import and Export to their own submenu pages

= 3.6.2.6 =
* Fixed a bug reported by some users regarding the php short tags usage

= 3.6.2.5 =
* Instead of a text box to enter the maximum number of link to be displayed in an article, there is a select input with Link Frequency options, from Low to High with 5 levels

= 3.6.2.4 =
* Module section have a separate menu item

= 3.6.2.3 =
* Exclude posts have a separate menu item

= 3.6.2.2 =
* Code cleaning and separated in multiple files

= 3.6.2 =
* Separated the code in more files ( install and cloaking )

= 3.6.1 =
* Improved the design for settings page

= 3.6.0.2 =
* Fixed edit links forms

= 3.7.0.1 =
* Fixed wrong permissions problems, based on the following ticket: http://wordpress.org/support/topic/permission-errors-2

= 3.6 =
* Moved General Settings page outside of plugin main page, in order to separate the options from the main linking area

= 3.5.7 =
* Keywords with the same affiliate link will be combined
* Added a notice to let people know about the pro version

= 3.5.6.1 =
* Changed permisions from "manage_options" to "publish_pages" so the editors can use the plugin

= 3.5.6 =
* Added a top menu for the plugin

= 3.5.5 = 
* Changed the order of the panels. Now the panel with affiliate links is loaded first.

= 3.5.4.4 =
* Eliminated keyword suggestion if they were already added

= 3.5.4.3 = 
* All suggested keywords are not hidden to avoid confusion.

= 3.5.4.2 = 
* When suggested keywords are added, they will be appended to the current input, instead of replacing the text inside

= 3.5.4.1 = 
* Changed some simple javascript code into jquery ( for suggested keywords )

= 3.5.4 = 
* Added 100 more keywords to suggestion list. The list will be hidden but upon a click it will expand and the most 100 keywords will be displayed with the possibility to be added to the form.

= 3.5.3.1 =
* Fixing some code that could cause problems to some environments

= 3.5.3 =
* Corrected some spelling errors

= 3.5.2 =
* Trying to fix the nofollow radio selector which semms to not working on some environments

= 3.5.1 = 
* Fixed Nofollow radio selector
* Tested the plugin with 3.6.1 Wordpress version
* Minor interface changes

= 3.4 =
* Exclude posts area now have instant post title and status recognition trough AJAX
* If the excluded post does not exist then it will be not added and a warning message will be triggered.

= 3.3.1 = 
* Fixed some minor issues and removed some unused code

= 3.3 =
* Fixed the way rewrite engine works, and made it available for non-permalinks structures.

= 3.2.2 =
* Module integration completed. Now modules can be added into /modules under plugin directory.

= 3.2.1 =
* Added module support, and created first dummy module

= 3.2 =
* Added the baselines for modules support

= 3.1.4 =
* Changed the JS code of tabs management

= 3.1.3 =
* Added the option to choose a different separator ( than those suggested in dropdown ) for datafeed import

= 3.1.2 =
* Changed the input type to select for separator option on file export

= 3.1.1 =
* Added separator option for export

= 3.1 =
* Added option to export all links

= 3.0.3 =
* Exclude post list will indicate the status of a post, and if it exist or not

= 3.0.2 =
* Added select instead of input for datafeed column delimiter

= 3.0.1 =
* Added option to select the delimiter for importing datafeed.

= 3.0 =
* Added option to import links trough a datafeed

= 2.9.5.8 =
* In exclude links menu you can now view the article

= 2.9.5.7 =
* Fixed menu design (current tab has different style)

= 2.9.5.6 =
* In Exclude ID's and Add Affiliates Link you can now delete just after delete 
* Also this update should fix some bugs that users has been reported
  
= 2.9.5.5 =
* Fixed edit bug and made some modifications that fixed some compatibility problems

= 2.9.5.4 =
* Fixed add new link problem (link was visible just after refresh)

= 2.9.5.3 =
* Fixed the conflict with the "add media" button

= 2.9.5.2 =
* Update to fix the bug from previous release that prevented users to add new links. 
* Update to fix the insert link and add media conflicts

= 2.9.5.1 =
* Changed the name of an included file to avoid any conflicts

= 2.9.5 =
* Moved exclude posts into separate tab
* Make delete and add exclude posts AJAX based

= 2.9.4 =
* General setings also converted to AJAX 

= 2.9.3 =
* Imported tabs menu from paid version and
* Some changes to the design 
* Better file and folder structure

= 2.9.2 =
* Added icon for delete button
* Add link is also done through AJAX for a better user experience

= 2.9.1 =
* Delete link functionality is done now through AJAX (without refreshing page)

= 2.9 =
* Updated the database table fields to match the pro version of the plugin.

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
* Modified the cloaking system to work with the latest versions of wordpress

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
* Added option to choose if you want to show original or cloaked links. 

= 2.3 = 
* Now all affiliate links are cloaked. Contribution of Jos Steenbergen

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
