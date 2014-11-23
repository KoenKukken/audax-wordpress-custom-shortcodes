=== Plugin Name ===
Contributors: Koen Kukken
Tags: shortcodes, custom
Requires at least: 3.0.1
Tested up to: 4.01
Stable tag: 1.0
License: none
License URI: none

== Description ==

Create and use your own shortcodes which can be used for... well... for anything you like! :) 
The initial goal of this plugin is to generalize data which you would use multiple times 
throughout your Wordpress website, like your contact information. 
When you put this information, like your home address, in shortcodes and you 
decide to go and live somewhere else, you just have to change your address at 
one single point and it will be changed in every page, post, comment or 
wherever you may have used your custom shortcode. 
The shortcode calls to a single field of data which can be controlled in the Audax control panel.

== Installation ==

1. Upload 'AudaxCustomShortcodes' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
    The plugin will automatically add a table to your database which will contain your shortcodes
    Make sure your MySQL user has at least the CREATE and ALTER privileges or else 
    the plugin won't be able to install or update later on.

== Frequently Asked Questions ==

= Where do I set my shortcodes =

Check your 'Settings' menu, it has a new submenu button called 'Custom Shortcodes'.

= How do i change my shortcodes =

You give each shortcode a collection, a label and a value. 
For example: collection = "address" label = "street" value = "Sesame Street".
You can call the example mentioned in pages, posts and comments with 
the shortcode: [audax_custom address="street"].
Sounds simple right? This example is limited to an address but you could 
also set product prices or a standard footer to appear at the bottom of each page.

= How do I call my shortcodes =

You can call your custom shortcodes in pages, posts and comments with 
the shortcode: [audax_custom address="street"].
Make sure you always start with an opening square bracket followed by audax_custom, 
this will call the function. Then write your collection (in this example 'address'). 
After that write: =" (no spaces) and then write your tag (in this example 'street') followed by a ". 
Close your shortcode with a closing square bracket.

== Screenshots ==

There are no screenshots available for this plugin

== Changelog ==

= 1.0 =
* Settings page has been added to edit your shortcodes in Wordpress instead of directly in your database

= 0.6 =
* The column 'active' has been added to the table to mark if a shortcode is active or inactive (deleted)

= 0.5 =
* First working version of using set custom shortcodes

== Upgrade Notice ==

= 1.0 =
Upgrade to edit your shortcodes in a Wordpress settings page