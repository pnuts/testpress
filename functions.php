<?php

ini_set('display_errors', 1);
include_once __DIR__ . '/include/TestPress.php';
include_once __DIR__ . '/lib/LessParser/Less.php';
include_once __DIR__ . '/controller/DefaultController.php';

use TestPress\TestPress;

$testpress = TestPress::getInstance();

add_action('init', array($testpress, 'initAction'));
add_action('wp_enqueue_scripts', array($testpress, 'enqueueScriptsAction'));

/* Admin Actions */
add_action('add_meta_boxes', array($testpress, 'addMetaBoxesAction'));
add_action("after_switch_theme", array($testpress, 'setUserRoles'));
add_action('after_setup_theme', array($testpress, 'removeAdminBar'));
add_action('admin_init', array($testpress, 'adminInitAction'));
add_action('admin_enqueue_scripts', array($testpress, 'adminEnqueueScriptsAction'));
add_action('admin_menu', array($testpress, 'changePostObjectLabel'));

/* Add Filters */
add_filter('wp_editor_settings', array($testpress, 'editorSettingsFilter'));

/**
 * @param array $rules array('url regex' => controller, ...)
 * @return bool|mixed
 */
function routes($rules) {
    $url = $_SERVER['REQUEST_URI'];
    foreach($rules as $rule => $controller) {
        if(preg_match($rule, $url, $fields)) {
            return call_user_func($controller, $fields);
        }
    }
    return false;
}

function get_partial($template, $args = array()) {
    set_query_var('args', $args);
    get_template_part($template, array('args' => $args));
}
