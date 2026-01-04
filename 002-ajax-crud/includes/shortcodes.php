<?php
defined('ABSPATH') || exit;

// * Add Employee Form
add_shortcode('advanced_ajax_crud_employee_form', function () {
    ob_start(); ?>

    <!-- Notification -->
    <div id="ajax-toast">
    </div>

    <!-- Form -->
    <h3 id="form-title">Add Employee</h3>
    <div>
        <input type="text" id="firstname"><br />
        <input type="text" id="lastname"><br />
        <input type="text" id="job_title"><br />
        <button id="addEmployee">Add</button>
        <button id="cancelEditEmployee">Cancel</button>
    </div>
<?php return ob_get_clean();
});
