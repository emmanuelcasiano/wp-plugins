jQuery(function ($) {
    $("#addEmployee").on("click", function () {
        let firstname = $("#firstname").val();
        let lastname = $("#lastname").val();
        let job_title = $("#job_title").val();

        $.post(advancedAjaxCrud.advanced_ajax_url, {
            action: "advanced_ajax_crud_add_employee",
            firstname: firstname,
            lastname: lastname,
            job_title: job_title,
            nonce: advancedAjaxCrud.nonce,
        })
            .done((response) => {
                $("#firstname").val("");
                $("#lastname").val("");
                $("#job_title").val("");
                showToast(response.data.message);
            })
            .fail((response) => {
                showToast(response.responseJSON.data.message);
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
