<?php

function AudaxCustomShortcodesInit() {
    global $wpdb;

    if (!get_option(AUDAX_CUSTOM_SHORTCODES_VERSION_KEY)) {
        if (!Audax\Database::checkPrivilege('CREATE')) {
            Audax\ErrorHandler::setError('The current MySQL user does not have the CREATE privilege which is needed for installing/updating this plugin. In order to use this plugin, please grant the current MySQL user permission to CREATE. You can change user privileges in your phpMyAdmin interface.', true);
        }
        $table = $wpdb->prefix . 'audax_custom_shortcodes';
        $wpdb->query('CREATE TABLE IF NOT EXISTS `' . $table . '` (`id` int(10) unsigned '
                . 'NOT NULL AUTO_INCREMENT, `collection` varchar(255) COLLATE '
                . 'utf8_unicode_ci NOT NULL, `tag` varchar(255) COLLATE '
                . 'utf8_unicode_ci NOT NULL, `value` varchar(255) COLLATE '
                . 'utf8_unicode_ci NOT NULL, PRIMARY KEY  (`id`)) ENGINE=InnoDB '
                . 'DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1');
        update_option(AUDAX_CUSTOM_SHORTCODES_VERSION_KEY, AUDAX_CUSTOM_SHORTCODES_VERSION);
    }
    
    // In v0.6 a column was added to the 'audax_custom_shortcodes' table
    if (get_option(AUDAX_CUSTOM_SHORTCODES_VERSION_KEY) !== false && 
            get_option(AUDAX_CUSTOM_SHORTCODES_VERSION_KEY) < '0.6') {
        if (!Audax\Database::checkPrivilege('ALTER')) {
            Audax\ErrorHandler::setError('The current MySQL user does not have the ALTER privilege which is needed for installing/updating this plugin. In order to use this plugin, please grant the current MySQL user permission to ALTER. You can change user privileges in your phpMyAdmin interface.', true);
        }
        $table = $wpdb->prefix . 'audax_custom_shortcodes';
        $wpdb->query("ALTER TABLE `" . $table . "` ADD `active` BIT(1) NOT NULL DEFAULT b'1'");
        update_option(AUDAX_CUSTOM_SHORTCODES_VERSION_KEY, '0.6');
    }
}