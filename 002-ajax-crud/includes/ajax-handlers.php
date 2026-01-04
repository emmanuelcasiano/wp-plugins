<?php
defined('ABSPATH') || exit;

// Create - Add Employee
add_action('wp_ajax_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee');
add_action('wp_ajax_nopriv_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee'); // allow guests if desired

function advanced_ajax_crud_add_employee()
{
    advanced_ajax_crud_require_auth_capability();
    advanced_ajax_crud_verify_nonce();

    global $wpdb;

    $firstname = sanitize_text_field($_POST['firstname']);
    $lastname = sanitize_text_field($_POST['lastname']);
    $job_title = sanitize_text_field($_POST['job_title']);

    $wpdb->insert(ADVANCED_AJAX_CRUD_TABLE, [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'job_title' => $job_title,
    ]);

    wp_send_json_success('Employee added');
}
