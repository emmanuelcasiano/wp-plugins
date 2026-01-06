jQuery(function ($) {
    // * Load Employees
    function loadEmployees() {
        $.post(advancedAjaxCrud.advanced_ajax_url, {
            action: "advanced_ajax_crud_employee_list",
        })
            .done((response) => {
                let html = '<table class="advanced-ajax-crud-employee-table">';
                html += `
                        <tr>
                            <th>ID</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Job Title</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>`;

                response.data.forEach((employee) => {
                    html += `
                            <tr data-id="${employee.id}">
                            <td>${employee.id}</td>
                            <td>${employee.firstname}</td>
                            <td>${employee.lastname}</td>
                            <td>${employee.job_title}</td>
                            <td>${employee.created_at}</td>
                            <td>
                                <button class="ajax-crud-employee-edit" data-id="${employee.id}">Edit</button>
                                <button class="ajax-crud-delete" data-id="${employee.id}">Delete</button>
                            </td>
                            </tr>`;
                });

                html += "</table>";

                jQuery("#advanced-ajax-crud-employee-list").html(html);
            })
            .fail((response) => {
                showToast(response.responseJSON.data.message);
            });
    }
    loadEmployees();

    // * Add Employee
    $("#addEmployee").on("click", function () {
        let id = $("#id").val();
        let firstname = $("#firstname").val();
        let lastname = $("#lastname").val();
        let job_title = $("#job_title").val();

        $.post(advancedAjaxCrud.advanced_ajax_url, {
            action: "advanced_ajax_crud_add_employee",
            id: id,
            firstname: firstname,
            lastname: lastname,
            job_title: job_title,
            nonce: advancedAjaxCrud.nonce,
        })
            .done((response) => {
                $("#id").val("");
                $("#firstname").val("");
                $("#lastname").val("");
                $("#job_title").val("");
                $("#addEmployee").text("Add");
                $("#cancelEditEmployee").hide();

                showToast(response.data.message);
                loadEmployees();
            })
            .fail((response) => {
                showToast(response.responseJSON.data.message);
            });
    });

    // * Edit Employee
    $(document).on("click", ".ajax-crud-employee-edit", function () {
        $("#form-title").text("Edit Employee");
        $("#addEmployee").text("Update");
        $("#cancelEditEmployee").show();

        const row = $(this).closest("tr");

        $("#id").val(row.data("id"));
        $("#firstname").val(row.children().eq(1).text());
        $("#lastname").val(row.children().eq(2).text());
        $("#job_title").val(row.children().eq(3).text());
    });

    $("#cancelEditEmployee").on("click", function () {
        $("#form-title").text("Add Employee");
        $("#addEmployee").text("Add");
        $("#cancelEditEmployee").hide();

        $("#id").val("");
        $("#firstname").val("");
        $("#lastname").val("");
        $("#job_title").val("");
    });

    // Helper for notification
    function showToast(message) {
        let toast = $("#ajax-toast");
        toast.text(message).fadeIn(200);

        setTimeout(() => {
            toast.fadeOut(300);
        }, 2000);
    }
});
