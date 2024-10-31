=== Network Only Plugins Tab ===
Contributors: brasofilo
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=JNJXKWBYM9JP6&lc=US&item_name=Rodolfo%20Buaiz&item_number=Network%20Only%20Plugins%20Tab&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted
Tags: multisite, plugins, network, admin, admin interface, tuning
Requires at least: 3.3
Tested up to: 3.7
Stable tag: 1.2
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.txt

List only plugins that are exclusive for Networks

== Description ==

Did you ever wonder which plugins are Network only? 
If you're not familiar, this kind of plugin only appears in the screen `/wp-admin/network/plugins.php`, 
available in Multisite installs. And there's nothing there telling us that. 
Well, not anymore, this plugin does that.

A custom screen will show only those plugins. And when viewing other plugin's screens, they'll be marked with a small customizable icon.

= Acknowledgments =
Uses [Font Awesome](http://fortawesome.github.io/Font-Awesome/) for displaying icons.

= Localizations =
* Português
* Español


== Installation ==
1. Upload the unzipped `network-only-plugins-tab.zip` to `/wp-content/plugins/` directory.
2. Activate the plugin through the *Network > Plugins* menu in WordPress.
3. Go to *Network -> Plugins*.

= Uninstall =
The file `uninstall.php` will clean the plugin option stored in the database.

== Frequently Asked Questions ==
= Different counts when viewing plugin screen =
When viewing the screen Network Only, the count of Active and Inactive reflects the number that are Network Only.

= What plugin is that in the screenshot, Network Deactivated but Active Elsewhere? =
Maybe I should bring it to the Repository, but for now it's on [GitHub](https://github.com/brasofilo/Network-Deactivated-but-Active-Elsewhere).

= Learn more about Multisite =
http://codex.wordpress.org/Create_A_Network

= Related plugins =
* [My Own Plugins Tab](https://github.com/brasofilo/My-Own-Plugins-Tab)
* [Favorites Sorter & Upload via URL](https://github.com/brasofilo/favorites-plugins-sorter)

= Doubts, bugs, suggestions =
Don't hesitate in posting a new topic here in [WordPress support forum](http://wordpress.org/tags/network-only-plugins-tab?forum_id=10).


== Screenshots ==
1. Plugin screen
2. Other plugin screens (network plugins marked)
3. Plugin settings

== Changelog ==

**Version 1.2**
* CSS adjustments. 

**Version 1.1**
* Added FontAwesome icons.
* Added plugin settings. 

**Version 1.0**

* Plugin launch. 

== Upgrade Notice ==

**Version 1.2**

* Adjusting CSS. 

== Acknowledgments ==

* Everything changed after [WordPress Stack Exchange](http://wordpress.stackexchange.com/)
