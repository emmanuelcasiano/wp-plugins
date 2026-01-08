jQuery(function ($) {
    // * Load Employees
    let currentPage = 1;
    function loadEmployees(page = 1) {
        currentPage = page;

        $.post(advancedAjaxCrud.advanced_ajax_url, {
            action: "advanced_ajax_crud_employee_list",
            page: page,
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

                response.data.employees.forEach((employee) => {
                    html += `
                            <tr data-id="${employee.id}">
                            <td>${employee.id}</td>
                            <td>${employee.firstname}</td>
                            <td>${employee.lastname}</td>
                            <td>${employee.job_title}</td>
                            <td>${employee.created_at}</td>
                            <td>
                                <button class="ajax-crud-employee-edit" data-id="${employee.id}">Edit</button>
                                <button class="ajax-crud-employee-delete" data-id="${employee.id}">Delete</button>
                            </td>
                            </tr>`;
                });

                html += "</table>";

                jQuery("#advanced-ajax-crud-employee-list").html(html);
                renderPagination(response.data);
            })
            .fail((response) => {
                showToast(response.responseJSON.data.message);
            });
    }
    loadEmployees(currentPage);

    // * Pagination Renderer
    function renderPagination(data) {
        const wrapper = $("#aaec-pagination");
        wrapper.empty();

        if (data.total_pages <= 1) return;

        // Prev
        if (data.current > 1) {
            wrapper.append(`<button class="button aaec-page" data-page="${data.current - 1}">« Prev</button>`);
        }

        // Pages
        for (let i = 1; i <= data.total_pages; i++) {
            wrapper.append(`
            <button
                class="button aaec-page ${i === data.current ? "button-primary" : ""}"
                data-page="${i}">
                ${i}
            </button>
        `);
        }

        // Next
        if (data.current < data.total_pages) {
            wrapper.append(`<button class="button aaec-page" data-page="${data.current + 1}">Next »</button>`);
        }
    }

    // * Pagination Click Handler
    $(document).on("click", ".aaec-page", function () {
        loadEmployees($(this).data("page"));
    });

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
                if (id) {
                    loadEmployees(currentPage);
                } else {
                    loadEmployees();
                }
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

    // * Delete Employee
    $(document).on("click", ".ajax-crud-employee-delete", function () {
        const id = $(this).closest("tr").data("id");

        $("#advanced-ajax-crud-employee-id").val(id);
        $("#advanced-ajax-crud-employee-delete-modal").fadeIn(150);
    });

    $("#advanced-ajax-crud-cancel, .advanced-ajax-crud-employee-modal-backdrop").on("click", function () {
        $("#advanced-ajax-crud-employee-delete-modal").fadeOut(150);
    });

    $(document).on("click", "#advanced-ajax-crud-delete", function (e) {
        e.preventDefault();
        const btn = $(this).prop("disabled", true);

        $.post(advancedAjaxCrud.advanced_ajax_url, {
            action: "advanced_ajax_crud_delete_employee",
            nonce: advancedAjaxCrud.nonce,
            id: $("#advanced-ajax-crud-employee-id").val(),
        })
            .done((response) => {
                showToast(response.data.message);
            })
            .fail((response) => {
                showToast(response.data.message);
            })
            .always(() => {
                btn.prop("disabled", false);
                $("#advanced-ajax-crud-employee-delete-modal").fadeOut(150);
                loadEmployees(currentPage);
            });
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
