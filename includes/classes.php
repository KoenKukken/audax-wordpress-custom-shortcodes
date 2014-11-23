<?php

namespace Audax;

class CustomShortcodes {

    protected static $customShortcodes = array();
    protected static $allShortcodes = array();

    /**
     * Get all values per collection
     * 
     * @param string $collection
     * @return boolean|array array on success or false on failure
     */
    public static function fetchCollection($collection) {
        global $wpdb;
        if (empty(self::$customShortcodes[$collection])) {
            $sql = $wpdb->prepare('SELECT tag, value FROM ' . $wpdb->prefix .
                    'audax_custom_shortcodes WHERE collection = %s AND active = 1', $collection);
            $rowShortcodes = $wpdb->get_results($sql, ARRAY_A);
            if (empty($rowShortcodes)) {
                return false;
            }
            foreach ($rowShortcodes as $shortcode) {
                self::$customShortcodes[$collection][$shortcode['tag']] = $shortcode['value'];
            }
        }
        return self::$customShortcodes[$collection];
    }

    public static function fetchAllShortcodes($sortByCollection = false) {
        global $wpdb;
        if (empty(self::$allShortcodes)) {
            $sql = 'SELECT * FROM ' . $wpdb->prefix . 'audax_custom_shortcodes '
                    . 'WHERE active = 1 ORDER BY collection';
            $rowShortcodes = $wpdb->get_results($sql, ARRAY_A);
            if (empty($rowShortcodes)) {
                return false;
            }
            foreach ($rowShortcodes as $shortcode) {
                self::$allShortcodes[$shortcode['id']] = array('id' => $shortcode['id'],
                            'collection' => $shortcode['collection'],
                            'tag' => $shortcode['tag'],
                            'value' => $shortcode['value']);
            }
        }
        if ($sortByCollection === true) {
            $returnArray = array();
            foreach (self::$allShortcodes as $id => $shortcode) {
                $returnArray[$shortcode['collection']][$id] = array('id' => $shortcode['id'],
                            'collection' => $shortcode['collection'],
                            'tag' => $shortcode['tag'],
                            'value' => $shortcode['value']);
            }
        }
        return self::$allShortcodes;
    }

    public static function save($collection, $tag, $value, $idShortcode = null) {
        if (!empty($idShortcode) && !is_numeric($idShortcode)) {
            throw new Exception('Invalid value ' . $idShortcode . ' for idShortcode in ' . __METHOD__);
        }
        if (empty($collection) || empty($tag)) {
            return false;
        }
        global $wpdb;
        if (empty($idShortcode)) {
            $result = $wpdb->query($wpdb->prepare('INSERT INTO '
                            . $wpdb->prefix . 'audax_custom_shortcodes '
                            . '(collection, tag, value, active) '
                            . 'VALUES(%s, %s, %s, 1)', trim($collection), trim($tag), $value));
        } else {
            $result = $wpdb->query($wpdb->prepare('UPDATE ' .
                            $wpdb->prefix . 'audax_custom_shortcodes'
                            . ' SET collection = %s, tag = %s, value = %s '
                            . 'WHERE id = %s', trim($collection), trim($tag), $value, $idShortcode));
        }
        if (count($result) === 0) {
            return false;
        }
        return true;
    }

    public static function delete($idShortcode) {
        if (empty($idShortcode) || !is_numeric($idShortcode)) {
            throw new Exception('Invalid value ' . $idShortcode . ' for idShortcode in ' . __METHOD__);
        }
        global $wpdb;
        $result = $wpdb->get_results($wpdb->prepare('UPDATE '
                        . $wpdb->prefix . 'audax_custom_shortcodes'
                        . ' SET active = 0 WHERE id = %s', $idShortcode));
        if (count($result) === 0) {
            return false;
        }
        return true;
    }

}

class Database {

    protected static $privileges = array();

    public static function checkPrivilege($privilege) {
        if (empty(self::$privileges)) {
            global $wpdb;
            $privileges = $wpdb->get_row('SHOW GRANTS FOR CURRENT_USER', ARRAY_N);
            if (empty($privileges)) {
                return false;
            }
            if (stripos($privileges[0], 'GRANT ALL PRIVILEGES') !== false) {
                self::$privileges[] = 'ALL';
            } else {
                $privileges = explode(', ', str_replace('GRANT ', '', $privileges[0]));
                foreach ($privileges as $fetchedPrivilege) {
                    if (strpos($fetchedPrivilege, ' ') !== false) {
                        self::$privileges[] = strstr($fetchedPrivilege, ' ', true);
                    } else {
                        self::$privileges[] = $fetchedPrivilege;
                    }
                }
            }
        }

        if (in_array(strtoupper($privilege), self::$privileges) || in_array('ALL', self::$privileges)) {
            return true;
        }
        return false;
    }

}

class ErrorHandler {

    protected static $errors = array();

    public static function setError($errorMessage, $kill = false) {
        $error = new \WP_Error('Test', $errorMessage);

        self::$errors[] = $error->get_error_message();

        if ($kill === true) {
            self::displayErrors();
        }
    }

    public static function checkErrors() {
        if (!empty(self::$errors)) {
            return true;
        } else {
            return false;
        }
    }

    public static function displayErrors() {
        wp_die(implode('<br />', self::$errors));
    }

}
