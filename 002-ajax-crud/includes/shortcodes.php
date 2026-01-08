<?php
defined('ABSPATH') || exit;

// * Employee List
add_shortcode('advanced_ajax_crud_employee_list', function () {
    ob_start(); ?>

    <div id="advanced-ajax-crud-employee-list">
        <p>Loading Employees...</p>
    </div>


    <!-- Delete Modal -->
    <div id="advanced-ajax-crud-employee-delete-modal" style="display: none;">
        <div class="advanced-ajax-crud-employee-modal-backdrop"></div>

        <div class="advanced-ajax-crud-employee-modal">
            <h2>Delete Employee</h2>

            <p id="advanced-ajax-crud-employee-delete-text">
                Are you sure you want to delete this employee?
            </p>

            <input type="hidden" id="advanced-ajax-crud-employee-id">

            <div class="advanced-ajax-crud-employee-modal-actions">
                <button id="advanced-ajax-crud-delete" class="button button-primary">Delete Permanently</button>
                <button id="advanced-ajax-crud-cancel" class="button">Cancel</button>
            </div>
        </div>
    </div>


<?php return ob_get_clean();
});

// * Add Employee Form
add_shortcode('advanced_ajax_crud_employee_form', function () {
    ob_start(); ?>

    <!-- Notification -->
    <div id="ajax-toast">
    </div>

    <!-- Form -->
    <h3 id="form-title">Add Employee</h3>
    <div>
        <input type="hidden" id="id">
        <input type="text" id="firstname"><br />
        <input type="text" id="lastname"><br />
        <input type="text" id="job_title"><br />
        <button id="addEmployee">Add</button>
        <button id="cancelEditEmployee">Cancel</button>
    </div>
<?php return ob_get_clean();
});
