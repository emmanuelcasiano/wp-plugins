<?php
defined('ABSPATH') || exit;

// * READ (Fetch Employee Data)
add_action('wp_ajax_advanced_ajax_crud_employee_list', 'advanced_ajax_crud_employee_list');
add_action('wp_ajax_nopriv_advanced_ajax_crud_employee_list', 'advanced_ajax_crud_employee_list');

function advanced_ajax_crud_employee_list()
{
    global $wpdb;

    $employees = $wpdb->get_results(
        "SELECT id, firstname, lastname, job_title, created_at
        FROM " . ADVANCED_AJAX_CRUD_TABLE . "
        ORDER BY created_at DESC",
        ARRAY_A
    );

    if (!$employees) {
        wp_send_json_error([
            'message' => 'Unable to fetch employees',
            'error'   => $wpdb->last_error,
        ], 500);
        return;
    }

    wp_send_json_success($employees);
}

// * Add (Insert Employee Data)
add_action('wp_ajax_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee');
add_action('wp_ajax_nopriv_advanced_ajax_crud_add_employee', 'advanced_ajax_crud_add_employee'); // allow guests if desired

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
    $id   = intval($_POST['id'] ?? 0);
    $firstname = sanitize_text_field($_POST['firstname']);
    $lastname = sanitize_text_field($_POST['lastname']);
    $job_title = sanitize_text_field($_POST['job_title']);

    if ($id > 0) {
        $updated = $wpdb->update(
            ADVANCED_AJAX_CRUD_TABLE,
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'job_title' => $job_title,
            ],
            [
                'id' => $id
            ],
            ['%s', '%s', '%s'],
            ['%d']
        );

        if (!$updated) {
            wp_send_json_error([
                'message' => 'Database insert/update failed',
                'error'   => $wpdb->last_error,
            ], 500);
            return;
        }
    } else {

        $inserted = $wpdb->insert(
            ADVANCED_AJAX_CRUD_TABLE,
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'job_title' => $job_title,
            ],
            ['%s', '%s', '%s']
        );
        wp_send_json_success(['message' => 'inserting xx']);
        return;

        if (!$inserted) {
            wp_send_json_error([
                'message' => 'Database insert/update failed',
                'error'   => $wpdb->last_error,
            ], 500);
            return;
        }
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
