=== Plugin Name ===
Contributors: Lucian Apostol
Donate link: http://autoaffiliatelinks.com
Tags: affiliate, links, post, plugin, posts, url, keywords, text, content, automatic
Requires at least: 2.5.2
Tested up to: 4.2.2
Stable tag: 4.9.8.6

Automatically display affiliate links in your website content so you can make more money. You can specify the keywords and affiliate links you want to be added or you can let the plugin to automatically decide where to add links from available affiliate networks: Amazon, Clickbank, Ebay, Walmart, Shareasale, Commission Junction, Bestbuy or Envato Marketplace.

== Description ==

Auto Affiliate Links will automatically add affiliate links into your content. You can manually set affiliate links and keywords where they should be added into your content, or you can let the plugin to automatically extract and display links from Amazon, Clickbank, Shareasale, Ebay, Walmart, Commission Junction, BestBuy and Envato Marketplace.

IMPORTANT: Your content won't be modified in any way. The links are added when the content is displayed. 

If you prefer to select your keywords and add your links manually, you can do this from "Auto Affiliate Links" menu in your administration panel. In "General Settings" you can set if you want the links to be cloaked, if you want them to be added on your homepage or not and several other options.

Also, you will have options to make the links nofollow or dofollow, to open in new page or same page and to cloak links. The plugin will give you the most used 100 keywords from your content si you can easily add affiliate links to appear when they are displayed. 

You can limit the number of links that are shown in every article. The frequency range from "Very Low" to "Very High". At Very Low level only 1 link will be displayed in every article. At "Very High" frequency a maximum of 5 links will be added to every article.

If you choose to automatically generate and display links from Amazon, Clickbank or Shareasale you have to first request an API key, and then to activate each module. The links will be added trough javascript so you do not have to worry about nofollowing and search engines. 




== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the plugin to the `/wp-content/plugins/` directory or download it directly from your administration panel.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Auto Affiliate Links' menu in your Wordpress Admin panel.
4. Add your affiliate links, along with one or more keywords. Do this for every affiliate link you want to display.
5. Select if you want your links to be nofollow, cloaked, to open in new window, and the maximum number of lniks that are added to every article. On some environments, the cloaking of the links is impossible. If you experience problems, turn the cloaking off and it should work just fine.
6. If you don't get it how to make it work, or if something goes wrong, please consult http://autoaffiliatelinks.com for more info and use the contact form on the website to report the problem or to ask for help.

== Screenshots ==

1. Affiliate link management

2. General Options

3. Amazon Links

4. Post example 1

5. Post example 2

== Frequently Asked Questions ==

= The plugin will modify the content in the database ? =

No, the plugin only add the links when the page is rendered. The content remain intact in your database.

= Cloaked links are not working, what should I do ? =

Link cloaking can cause problems on some environments ( shared hosting with too many restrictions ). If you experience problems please turn cloaking off.

= Do i have to change my theme to make the plugin work? =

No theme changes are needed for this plugin. 

= How it will affect my design and blog functionality ? =

The blog functionality will not be affected in any way. Links will be added in your content and they will look just like normal links. 

= How do I make links nofollow ? =

On the plugin management page: "Auto Affiliate Links" under "Settings", you will have the option to set a link to have rel="nofollow" attribute.

= How do I make the links to open in new window ? =

On the plugin management page: "Auto Affiliate Links" under "Settings", you will have the option to set the links to open in new or in the same window. By default, links will open in a new window. As a matter of fact, it is better for external links to open in new window, so the user will notice that he is on another website right now, and to have your website still open, if he want to read more or to visit another link.

= Can I add the same affiliate link with more keywords ? =

Yes. You can add more keywords in the same box, sepparated by comma. For example: "android,smartphone,phones". If you add the same link 3 times with different keywords the result will be the same: The link will appear for all the keywords added. 

= Can I add more links for the same keyword ? =

If you add more links with the same keyword, only the first occurence of the keyword will add the first link. If the same keyword appear again in the article, the second link will be added on it.

= How Clickbank links work =

First you have to request an API key from the "API Key" menu. Then, from the "Clickbank Links" menu you will have to enter your affiliate id, category and minimum gravity ( leave 0 for all links ), and set the plugin to "active". Once you do this links from clickbank will start to show on your pages.

= The plugin makes my blog to show odd html code = 

If you encounter any problem with the plugin, please contact us using the form at http://autoaffiliatelinks.com and we will help you to solve your issue. It has been reported that some lightbox plugin my be interfeering with our plugin. 

= Is there a maximum limit on number of manual links I can import? =

There isn't a software limit of how many links you can import. However, you should take into account that uploading a big file at once might cause problems with: maximum file size upload limit on your server ( it is usually 2MB ), and the fact that the script can break or exceed maximum execution time ( 30 seconds ), and only a part of the links will be saved. You should break your uploads into 100-200 links at once.

VERY IMPORTANT. Processing big lists of links ( over 500 ), might cause high server load if you are on a shared hosting, and the page load will be affected. Make sure that you only put the amount of links that you server can handle. With under 500 links you should be safe on every server type.

= My CSV Import file is not working =

Before attempting to import a file, make sure that the csv file is encoded as text file and does not have any custom formatting in it.

Microsoft Excel adds odd formatting to the file and making problems at import and even breaking it. When you save a file in Microsoft Excel, make sure that you check the document type to be txt or csv, to prevent odd formatting, and on that page it should also let you select the separator or delimiter.

If you can't find the options to do this, try LibreOffice, as it is a bit easier to find them there.

== Changelog ==

= 4.9.8.6 =
* Changed the way clickbank categories are displayed

= 4.9.8.5 =
* Minor tweak on homepage display

= 4.9.8.4 =
* Minor fix for some environments

= 4.9.8.3 =
* Tested for Wordpress 4.2.2

= 4.9.8.2 =
* Removed some unused code

= 4.9.8.1 =
* Fixed cloaked links bug that gave to all links the same id

= 4.9.8 =
* Reviewed design and fixed small issues
* Added warning message when there are no links added

= 4.9.7.13 =
* Removed wp prefix from page titles

= 4.9.7.12 -
* Checked and tested with Wordpress 4.2.1

= 4.9.7.11 =
* Checked and adapted to work with Wordpress 4.2

= 4.9.7.10 =
* Stylized save button for affiliate links

= 4.9.7.9 =
* Tested and adapted for Wordpress 4.1.2

= 4.9.7.8 =
* Rearranged some javascript code
* Removed unused leftover code

= 4.9.7.7 =
* Updated plugin instructions on main page and getstarted text.

= 4.9.7.6 =
* Made keyword and url input fields bigger and responsive
* On exclude posts page, made post title column bigger and responsive

= 4.9.7.5.2 =
* Fixed bug causing the same link to be added to all keywords

= 4.9.7.5.1 =
* Fixed homepage display bug generated by previous update

= 4.9.7.5 =
* Added link priority based on the number of words in a keyphrase, and then number of characters

= 4.9.7.4 =
* Changed exclude posts administration page text to reflect latest updates

= 4.9.7.3 =
* Added option to exclude posts by URL

= 4.9.7.2 =
* Removed some debug code

= 4.9.7.1 =
* Added default values for several options

= 4.9.7 =
* Changed database collation to utf8_general_ci
* Added default value for Link frequency to Average.

= 4.9.6.3 =
* Fixed notice message bug

= 4.9.6.2 =
* Fixed exclude posts deletion problem

= 4.9.6.1 =
* Changed some and added some warning messages
* Removed some redundant code.

= 4.9.6 =
* Added extra input filtering for more security

= 4.9.5.1 =
* Added description to exclude rules form

= 4.9.5 =
* Removed "Wp" reference from plugin name and menu titles

= 4.9.4 =
* Added option to exclude posts created before a specific date

= 4.9.3.7 =
* Changed some links to more information.

= 4.9.3.6 =
* Cleaned some jquery code

= 4.9.3.5 =
* Added "no limit" option to same keyword limit

= 4.9.3.2 =
* Tested and updated for wordpress 4.1.1

= 4.9.3.1 =
* Fixed some minor display bugs
* Removed old unused code

= 4.9.3 =
* If the value for "links in every article" is set to 0, then no automated links are added.
* Added "No Links" option to "Link Frequency" select. If this option is set, then the plugins won't display any links
* If the link frequency is set to custom, then the word count will have no effect to the number of links shown

= 4.9.2 =
* Applied wordpress style to submit buttons
* Rearranged some code, removed unnecessary comments, fixed the indenting, removed unnecessary blank lines

= 4.9.1 =
* Updated plugin description

= 4.9 =
* Created a Getting Started page with information on how to use the plugin.

= 4.8.5 =
* Removed some unused content added by the plugin
* Clean javascript debug code
* Rearranged items in main plugin page
* Moved notification message from Amazon page to main plugin page

= 4.8.4 =
* Added option to import previously exported settings
* Updates export option list

= 4.8.3 =
* Fixed API key status reporting messages
* Cache is now reset every 3 days
* Added a comma between keyphrases in generated links page

= 4.8.2 =
* Added mass delete actions for Shareasale and Commission Junction custom links added trough datafeed

= 4.8.1 =
* Removed code not needed anymore
* Added some messages regarding api key status

= 4.8 =
* Updated instructions and messages to reflect recent features added to the plugin
* Cleared the code for debugging variables and old commented code
* Checked and tested the plugin for Wordpress 4.1

= 4.7.6 =
* Custom uploaded links for modules can now be removed directly

= 4.7.5 =
* Uploaded affiliate links will be shown in the Shareasale links page

= 4.7.4 =
* Generated links are now requested, parsed and displayed trough javascript

= 4.7.3.3 =
* Removed a warning message on "generated links page" when there are no links to display
* Added a warning message for server configurations that prevent loading external files trough php.

= 4.7.3.2 =
* Minor fix for some webhosting configuration when validating api key

= 3.7.3.1 =
* Excluded attachments, nav menu items and revisions for content type selection
* Changed some text inside the plugin

= 4.7.3 =
* Improved the way which content is auto affiliate links activated for
* Let user to select any content type for affiliate linking

= 4.7.2 =
* Module submenu items are not shown if they are not activated from API management page.

= 4.7.1 =
* Added Envato options and settings link on API management page

= 4.7 =
* Added module for Envato Marketplace links

= 4.6.4.8 =
* Performance improvement for API users

= 4.6.4.7 =
* Fixed Exclude post bug. Whenever general settings were saved, excluded posts were reset.

= 4.6.4.6 =
* Displayed links from CJ affiliates on the module page

= 4.6.4.6 =
* Checked and tested for wordpress 4.0.1 compatibility issues

= 4.6.4.4 =
* Quick change to general settings: hide the custom link frequency input unless selector is set to custom

= 4.6.4.3 =
* For the situation when the plugin is used for internal linking, now it won't show a link if the target is the same with the post permalink

= 4.6.4.2 =
* Added the ability to export the settings

= 4.6.4.1 =
* Updated texts into the plugin to reflect the latest updates

= 4.6.4 =
* Added walmart activation into module configuration page
* Reordered modules links in main menu
* Changed plugin subpage slugs to prevent conflicts

= 4.6.3 =
* Created module to automatically add Walmart affiliate links

= 4.6.2 =
* Added activation/deactivation options for the latest modules added.
* Added links on API management page to module configuration pages.

= 4.6.1 =
* Created module to automatically add BestBuy links ( trought bestbuy api, working with linkshare affiliates )

= 4.6 =
* Created module to automatically add Ebay affiliate links

= 4.5 =
* Created module to automatically add Commission Junction affiliate links

= 4.4.3.2 =
* Fixed shareasale link addition

= 4.4.3.1 =
* Added an info message on api management page

= 4.4.3 =
* Modules can be activated/deactivated from "Activate PRO Features" page

= 4.4.2.3 =
* Minor fix for plugin notice

= 4.4.2.2 =
* Fixed the way new exclude posts are displayed into the "Exclude Posts" page. Also fixed the exclude posts delete button

= 4.4.2.1 =
* Added option to add a custom value for the number of links to be added in every article 

= 4.4.2 =
* Checked and tested for Wordpress 4.0 release

= 4.4.1 =
* Fixed tld issues for co.jp and co.uk amazon websites

= 4.4 =
* Added support for other amazon websites (de,it,uk,cn,in,es,fr)

= 4.3.5.1 =
* Added alternation for table row background in generated links page

= 4.3.5 =
* Changed the layout of generated links page

= 4.3.4.4 =
* Fixed minor issue when selecting all links

= 4.3.4.3 =
* The same keyword can be set to be linked more than once

= 4.3.4.2 =
* Added list sorting options on the bottom of the list too

= 4.3.4.1 = 
* Fixed a minor issue caused by recent debuggings. 

= 4.3.4 =
* The link frequency is not adjusted by the lenght of the post

= 4.3.3.6 =
* Fixed the problems with adding links on fresh installs.

= 4.3.3.5 =
* Checked the compatibility with the latest wordpress version ( 3.9.2 )

= 4.3.3.4 =
* Added links to support forum and faq section from different pages of the plugin

= 4.3.3.3 =
* Small tweak for ssl installations

= 4.3.3.2 =
* Affiliate links now open in new windows by default on a fresh installation

= 4.3.3.1 =
* Added links to support forum and FAQ section.

= 4.3.3 =
* Added option to select if links should be displayed on posts only, pages only, or both.
* Excluded all other post types except posts and pages for execution.

= 4.3.2 =
* Order capability for affiliate links added

= 4.3.1.1 =
* Updated FAQ section
* Added some more info text inside the plugin

= 4.3.1 =
* Added option to delete multiple links at the same time
* Added option to select all links on the page

= 4.3.0.3 =
* Added a confirmation box when the settings are updated

= 4.3.0.2 =
* Added an index.php file in every directory so directory content won't be seen from outside in certain environments

= 4.3.0.1 =
* Fixed a small bug caused by the latest update

= 4.3 =
* Added support for international chars ( european, russian, chinese, japanese, korean ). This has to be activated from plugin General settings page and the database should have the right charset, utf8_general_ci seems to be working well with this.

= 4.2.8 =
* Removed some development code  from metabox
* If a post does not have any links generated, it will show a message instead of a blank cell
* After a link is added, the link input will show again http:// so the user can add only the link after.

= 4.2.7 =
* Rearranged items in excluded post page

= 4.2.6.1 =
* Fixed some error messages

= 4.2.6 =
* Generated links page won't show if there is not an api key added.

= 4.2.5 =
* User have the option to add his own css class to be assigned to automated links.

= 4.2.4 =
* performance improvements

= 4.2.3 =
* Prevented duplicate posts to show in generated links

= 4.2.2 =
* Show post exclusion status in generated links page

= 4.2.1 =
* Added a metabox when editing posts to exclude them from link addition

= 4.2 =
* Created a new page for displaying Automated generated links.
* The generated links page shows Amazon, Clickbank and Shareasale links.
* The generated links page has its own submenu item

= 4.1.2 =
* Fixed a bug that displayed column headers in every row from last update

= 4.1.1 =
* Displaying generated links on clickbank page

= 4.1.0 =
* More details added to api management page

= 4.0.9 =
* Additional check on exclude post adding. If there is already a post added with that id.

= 4.0.8 = 
* Removed unused input box on exclude posts page

= 4.0.7 =
* Fixed some issues with amazon categories.

= 4.0.6 =
* Added api key verification

= 4.0.5 =
* Minor bug fixes

= 4.0.4 =
* Rearranged API management page

= 4.0.3 =
* Removed revenue sharing.

= 4.0.2 =
* Removed unused Modules menu

= 4.0.1 =
* Tested with Wordpress 3.9.1 version

= 4.0 =
* Added Premium features into the plugin
* Amazon links can be added automatically based on your content
* Clickbanks links will be added automatically based on your content
* Removed some old code

= 3.10.9 =
* Fixed a minor bug created in previous release

= 3.10.8 =
* Removed some backup files

= 3.10.7 =
* Fixed the bug that made links to be added inside <h> tags

= 3.10.6 =
* Updated plugin description

= 3.10.5 =
* Fixed links home page display when using amazon, clickbank or shareasale modules.

* 3.10.4 = 
* Added a notice about PRO features

= 3.10.3 =
* Rearrenged keyword suggestion and removed short ( under 5 chars ) and all numeric keyphrases

= 3.10.2 =
* Removed some debug leftover code

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
