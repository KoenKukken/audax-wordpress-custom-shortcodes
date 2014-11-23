<?php
// Check if the current user is allowed to run this function
if (!current_user_can('manage_options')) {
        wp_die('You do not have permission to access this page.');
    }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['audax-custom-shortcodes-form-save'])) {
        // Check if all required variables are set
        if (!empty($_POST['audax-custom-shortcodes-collection']) &&
                !empty($_POST['audax-custom-shortcodes-tag']) &&
                !empty($_POST['audax-custom-shortcodes-value'])) {
            $collectionArray = $_POST['audax-custom-shortcodes-collection'];
            $tagArray = $_POST['audax-custom-shortcodes-tag'];
            $valueArray = $_POST['audax-custom-shortcodes-value'];
            $deleteArray = !empty($_POST['audax-custom-shortcodes-delete']) ? $_POST['audax-custom-shortcodes-delete'] : array();
            $newCollectionArray = !empty($_POST['audax-custom-shortcodes-new-collection']) ? $_POST['audax-custom-shortcodes-new-collection'] : array();
            $newTagArray = !empty($_POST['audax-custom-shortcodes-new-tag']) ? $_POST['audax-custom-shortcodes-new-tag'] : array();
            $newValueArray = !empty($_POST['audax-custom-shortcodes-new-value']) ? $_POST['audax-custom-shortcodes-new-value'] : array();
            // Run actions for existing shortcodes
            foreach ($collectionArray as $key => $collection) {
                if (!empty($deleteArray[$key])) {
                    Audax\CustomShortcodes::delete($key);
                } else {
                    Audax\CustomShortcodes::save($collection, $tagArray[$key], $valueArray[$key], $key);
                }
            }
            // Run actions for new shortcodes
            foreach ($newCollectionArray as $key => $collection) {
                Audax\CustomShortcodes::save($collection, $newTagArray[$key], $newValueArray[$key]);
            }
            // Unset all used variables so they won't collide with other plugins
            unset($collectionArray, $tagArray, $valueArray, $deleteArray, 
                    $newCollectionArray, $newTagArray, $newValueArray);
        }
    }
}