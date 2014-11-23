<?php

function getCustomShortcode($attribute) {
    foreach ($attribute as $collection => $tag) {
        $shortcodeArray = Audax\CustomShortcodes::fetchCollection($collection);
        if ($shortcodeArray !== false && !empty($shortcodeArray[$tag])) {
            return $shortcodeArray[$tag];
        }
    }
    return null;
}

function audaxCustomShortcodesAdminMenu() {
    $pageTitle = 'Audax Custom Shortcodes Settings';
    $menuTitle = 'Custom Shortcodes';
    $privileges = 'manage_options';
    $menuSlug = 'audaxCustomShortcodesSettings';
    $functionName = 'audaxCustomShortcodesSettings';
    add_options_page($pageTitle, $menuTitle, $privileges, $menuSlug, $functionName);
}

function audaxAdminMenu() {
    $pageTitle = 'Audax';
    $menuTitle = 'Audax';
    $privileges = 'manage_options';
    $menuSlug = 'audax-settings';
    $functionName = 'audaxCustomShortcodesSettings';
    add_menu_page($pageTitle, $menuTitle, $privileges, $menuSlug, $functionName);

    // Add submenu page with same slug as parent to ensure no duplicates
    $subMenuTitle = 'Settings';
    add_submenu_page($menuSlug, $pageTitle, $subMenuTitle, $privileges, $menuSlug, $functionName);

    // Add the submenu page for Help
    $submenuPageTitle = 'Audax Help';
    $submenuTitle = 'Help';
    $submenuSlug = 'audax-help';
    $submenuFunctionName = 'audaxHelp';
    add_submenu_page($menuSlug, $submenuPageTitle, $submenuTitle, $privileges, $submenuSlug, $submenuFunctionName);
}

function audaxCustomShortcodesSettings() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this page.');
    }
    require_once AUDAX_CUSTOM_SHORTCODES_PLUGIN_DIR . 'process/MenuProcess.php';
    require_once AUDAX_CUSTOM_SHORTCODES_PLUGIN_DIR . 'includes/view/OptionsPage.phtml';
    add_action('admin_init', 'audaxCustomShortcodesAdminInit');
}

function audaxHelp() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this page.');
    }

    require_once AUDAX_CUSTOM_SHORTCODES_PLUGIN_DIR . 'includes/view/HelpPage.phtml';
}

function audaxCustomShortcodesPluginActionLinks($links, $file) {
    if ($file == AUDAX_CUSTOM_SHORTCODES_PLUGIN_LOADFILE) {
        $settingsLink = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=audaxCustomShortcodesSettings">Settings</a>';
        array_unshift($links, $settingsLink);
    }
    return $links;
}

function errorHandler($errorMessage, $kill = false) {
    $error = new WP_Error('Test', $errorMessage);

    echo $error->get_error_message();

    if ($kill === true) {
        exit;
    }
}