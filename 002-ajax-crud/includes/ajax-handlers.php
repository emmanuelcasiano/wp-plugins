<?php
defined('ABSPATH') || exit;

// Create - Add Employee
add_action('wp_ajax_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee');
add_action('wp_ajax_nopriv_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee'); // allow guests if desired

// * Add (Insert Employee Data)
function advanced_ajax_crud_add_employee()
{
    advanced_ajax_crud_require_auth_capability();
    advanced_ajax_crud_verify_nonce();

    $errors = [];

    // Validate fields
    if (empty($_POST['firstname'])) {
        $errors['firstname'] = 'Firstname is required';
    }

    if (empty($_POST['lastname'])) {
        $errors['lastname'] = 'Lastname is required';
    }

    if (empty($_POST['job_title'])) {
        $errors['job_title'] = 'Job title is required';
    }

    // If there are validation errors, return them all
    if (!empty($errors)) {
        wp_send_json_error([
            'message' => 'Validation failed',
            'errors'  => $errors
        ], 400);
        return;
    }

    global $wpdb;

    // Sanitize input
    $firstname = sanitize_text_field($_POST['firstname']);
    $lastname = sanitize_text_field($_POST['lastname']);
    $job_title = sanitize_text_field($_POST['job_title']);

    $inserted = $wpdb->insert(
        ADVANCED_AJAX_CRUD_TABLE,
        [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'job_title' => $job_title,
        ],
        ['%s', '%s', '%s']
    );

    if (!$inserted) {
        wp_send_json_error([
            'message' => 'Database insert failed',
            'error'   => $wpdb->last_error,
        ], 500);
        return;
    }

    wp_send_json_success([
        'message'       =>  'Employee added',
        'id'            =>  $wpdb->insert_id,
        'firstname'       =>  'firstname',
        'lastname'       =>  'lastname',
        'job_title'       =>  'job_title',
        'message'       =>  'Employee added',
    ]);
}
