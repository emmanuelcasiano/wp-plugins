<?php

/**
 * Plugin Name: WP Advanced AJAX CRUD
 *  Description: This plugin is an advanced AJAX CRUD
 * Author: ECDev
 */

defined('ABSPATH') || exit;

define('AJAX_CRUD_PATH', plugin_dir_path(__FILE__));
define('AJAX_CRUD_URL', plugin_dir_url(__FILE__));

require_once AJAX_CRUD_PATH . 'includes/activator.php';
require_once AJAX_CRUD_PATH . 'includes/ajax-handlers.php';
require_once AJAX_CRUD_PATH . 'includes/shortcodes.php';
require_once AJAX_CRUD_PATH . 'includes/helpers.php';

/**
 * Assets
 */
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_script(
        'advanced-ajax-crud-js',
        AJAX_CRUD_URL . 'assets/js/script.js',
        ['jquery'],
        null,
        true
    );

    wp_localize_script('advanced-ajax-crud-js', 'ajaxCrud', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('ajax_crud_nonce')
    ]);

    wp_enqueue_style(
        'advanced-ajax-crud-css',
        AJAX_CRUD_URL . 'assets/css/style.css'
    );
});
