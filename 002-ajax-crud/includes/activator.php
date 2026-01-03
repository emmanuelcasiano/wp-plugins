<?php
defined('ABSPATH') || exit;

global $wpdb;
define('ADVANCED_AJAX_CRUD_TABLE', $wpdb->prefix . 'employees');

function advanced_ajax_crud_create_table()
{
    global $wpdb;

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    $charset_collate = $wpdb->get_charset_collate();
    $table_name = ADVANCED_AJAX_CRUD_TABLE;

    $sql = "CREATE TABLE $table_name (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        firstname VARCHAR(255) NOT NULL,
        lastname VARCHAR(255) NOT NULL,
        job_title VARCHAR(255),
        description LONGTEXT,
        email VARCHAR(190),
        website VARCHAR(255),
        quantity INT DEFAULT 0,
        price DECIMAL(10,2) DEFAULT 0.00,
        is_active TINYINT(1) DEFAULT 1,
        type VARCHAR(50),
        image_id BIGINT UNSIGNED,
        meta JSON NULL,
        status VARCHAR(50),
        created_by BIGINT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )$charset_collate;";

    dbDelta($sql);
}
