<?php

/*
 * Plugin Name:     Audax Custom Shortcodes
 * Plugin URI:      
 * Description:     Create and use your own shortcodes which can be used for... well... for anything you like! :) The initial goal of this plugin is to generalize data which you would use multiple times throughout your Wordpress website, like your contact information. When you put this information, like your home address, in shortcodes and you decide to go and live somewhere else, you just have to change your address at one single point and it will be changed in every page, post, comment or wherever you may have used your custom shortcode. The shortcode calls to a single field of data which can be controlled in the Audax control panel.
 * Version:         1.0
 * Author:          Koen Kukken
 * Language:        EN_en
 * Author URI:      http://github.com/koenkukken
 * License:         Happy2Share 
 */

if (!defined('AUDAX_CUSTOM_SHORTCODES_PLUGIN_TITLE')) {
    define('AUDAX_CUSTOM_SHORTCODES_PLUGIN_TITLE', 'Audax Custom Shortcodes');
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_PLUGIN_NAME')) {
    define('AUDAX_CUSTOM_SHORTCODES_PLUGIN_NAME', trim(dirname(plugin_basename(__FILE__)), '/'));
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_PLUGIN_DIR')) {
    define('AUDAX_CUSTOM_SHORTCODES_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . AUDAX_CUSTOM_SHORTCODES_PLUGIN_NAME);
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_PLUGIN_URL')) {
    define('AUDAX_CUSTOM_SHORTCODES_PLUGIN_URL', WP_PLUGIN_URL . '/' . AUDAX_CUSTOM_SHORTCODES_PLUGIN_NAME);
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_PLUGIN_LOADFILE')) {
    define('AUDAX_CUSTOM_SHORTCODES_PLUGIN_LOADFILE', AUDAX_CUSTOM_SHORTCODES_PLUGIN_NAME . '/AudaxCustomShortcodesControl.php');
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_VERSION_KEY')) {
    define('AUDAX_CUSTOM_SHORTCODES_VERSION_KEY', 'audax_custom_shortcodes_version');
}
if (!defined('AUDAX_CUSTOM_SHORTCODES_VERSION')) {
    define('AUDAX_CUSTOM_SHORTCODES_VERSION', '1.0');
}

require_once 'includes/classes.php';
require_once 'includes/functions.php';
require_once 'includes/initialize.php';

//add_action('admin_menu', 'audaxAdminMenu');
add_action('admin_menu', 'audaxCustomShortcodesAdminMenu');
add_filter('plugin_action_links', 'audaxCustomShortcodesPluginActionLinks', 10, 2);

add_shortcode('audax_custom', 'getCustomShortcode');

register_activation_hook(__FILE__, 'AudaxCustomShortcodesInit');

if (Audax\ErrorHandler::checkErrors() === true) {
    Audax\ErrorHandler::displayErrors();
}