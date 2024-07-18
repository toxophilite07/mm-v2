$(function () {
    $("#feminine_table").DataTable({
        aLengthMenu: [
            [5, 10, 20, -1],
            [5, 10, 20, "All"],
        ],
        iDisplayLength: 10,
        sAjaxSource: "../health-worker/feminine-data",
        columns: [
            { data: "row_count" },
            { data: "full_name" },
            { data: "menstruation_status" },
            { data: "is_active" },
            { data: "estimated_menstrual_status" },
            { data: "action" },
        ],
    });
    $("#feminine_table").each(function () {
        var datatable = $(this);
        var search_input = datatable
            .closest(".dataTables_wrapper")
            .find("div[id$=_filter] input");
        search_input.attr("placeholder", "Search");
        search_input.removeClass("form-control-sm");

        var length_sel = datatable
            .closest(".dataTables_wrapper")
            .find("div[id$=_length] select");
        length_sel.removeClass("form-control-sm");
    });
});

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $("#viewFeminineModal").on("show.bs.modal", function (e) {
        var button = $(e.relatedTarget);
        var last_period_dates = button.data("last_period_dates");

        var modal = $(this);
        modal.find(".modal-body #view_name").text(button.data("full_name"));
        modal.find(".modal-body #view_email").text(button.data("email"));
        modal
            .find(".modal-body #view_contact_no")
            .text(`+63${button.data("contact_no")}`);
        modal
            .find(".modal-body #view_birthdate")
            .text(button.data("birthdate"));
        modal.find(".modal-body #view_address").text(button.data("address"));

        modal
            .find(".modal-body #view_is_active")
            .text(button.data("is_active") === 1 ? "• Verified" : "• Pending");

        modal
            .find(".modal-body #view_menstruation_status")
            .text(
                button.data("menstruation_status") === 1
                    ? "• Active"
                    : "• Inactive"
            );

        if (last_period_dates.length != 0) {
            $.each(last_period_dates, function (i, value) {
                var created_at = new Date(value.created_at);
                var last_period_date = new Date(value.menstruation_date);
                var month_arr = [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ];

                var currentDate = new Date();
                var dateText =
                    month_arr[last_period_date.getMonth()] +
                    " " +
                    last_period_date.getDate() +
                    ", " +
                    last_period_date.getFullYear();
                var period_date = $(
                    '<p class="text-muted m-0">• ' + dateText + "</p>"
                );

                if (created_at.toDateString() <= currentDate.toDateString()) {
                    var new_label = $(
                        '<span class="badge badge-pill badge-success ml-2">New</span>'
                    );
                    period_date.append(new_label);

                    $.ajax({
                        url: "../admin/post-seen/period-notification",
                        type: "POST",
                        data: {
                            id: value.id,
                        },
                        success: function (res) {
                            if (res.id) {
                                $(document)
                                    .find("#period_notification_body_" + res.id)
                                    .remove();
                                $("#feminine_table").DataTable().ajax.reload();
                            }
                        },
                    }).done(function (res) {
                        if (res.new_notification_count == 0) {
                            $(document)
                                .find("#period_notification_indicator")
                                .addClass("hidden");
                            $(document)
                                .find(".period_notification_count")
                                .text("No Notifications");
                            $(document)
                                .find("#period_notification_container")
                                .empty()
                                .append(
                                    '\
                                <a href="#" class="dropdown-item">\
                                    <div div class= "icon" >\
                                        <i class="fa-solid fa-mug-hot"></i>\
                                    </div >\
                                    <div class="content">\
                                        <p>No notifications have a coffee</p>\
                                    </div>\
                                </a >\
                    '
                                );
                        } else {
                            $(document)
                                .find(".period_notification_count")
                                .text(
                                    res.new_notification_count +
                                        " New Notifications"
                                );
                        }
                    });
                }

                modal
                    .find(".modal-body #view_last_periods")
                    .append(period_date);

                modal
                    .find(".modal-body #view_estimated_periods")
                    .text(button.data("estimated_next_period"));
            });
        } else {
            modal
                .find(".modal-body #view_last_periods")
                .append('<p class="text-muted m-0">• No record found</p>');
        }
    });

    $("#editFeminineModal").on("show.bs.modal", function (e) {
        var modal = $(this);
        if (e.relatedTarget != null) {
            var button = $(e.relatedTarget);

            modal
                .find(".modal-body #edit_last_period_date")
                .datepicker("setDate", button.data("last_period_date"));
            modal
                .find(".modal-body #edit_birthdate")
                .datepicker("setDate", button.data("birthdate"));

            modal.find(".modal-body #edit_id").val(button.data("id"));
            modal
                .find(".modal-body #edit_menstruation_period_id")
                .val(button.data("menstruation_period_id"));
            modal
                .find(".modal-body #edit_first_name")
                .val(button.data("first_name"));
            modal
                .find(".modal-body #edit_middle_name")
                .val(button.data("middle_name"));
            modal.find(".modal-body #edit_address").val(button.data("address"));
            modal
                .find(".modal-body #edit_last_name")
                .val(button.data("last_name"));
            modal
                .find(".modal-body #edit_email_address")
                .val(button.data("email"));
            modal
                .find(".modal-body #edit_contact_no")
                .val(button.data("contact_no"));
            modal.find(".modal-body #edit_remarks").val(button.data("remarks"));
            modal
                .find(".modal-body #edit_menstruation_status option")
                .removeAttr("selected")
                .end()
                .find(
                    '#edit_menstruation_status option[value="' +
                        button.data("menstruation_status") +
                        '"]'
                )
                .attr("selected", true)
                .end();
        }
    });

    $(document).on("click", ".delete_record", function (e) {
        Swal.fire({
            title: "Unassigned Feminine?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Unassigned User",
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../health-worker/delete-feminine",
                    type: "POST",
                    data: {
                        id: $(this).data("id"),
                    },
                    success: function (response) {
                        $("#feminine_table").DataTable().ajax.reload();
                        iziToast.info({
                            close: false,
                            displayMode: 2,
                            layout: 2,
                            position: "topCenter",
                            drag: false,
                            title: "Success!",
                            message:
                                "Feminine has been successfully removed from the list.",
                            transitionIn: "bounceInDown",
                            transitionOut: "fadeOutUp",
                        });
                    },
                    error: function (response) {
                        iziToast.error({
                            close: false,
                            displayMode: 2,
                            position: "topCenter",
                            drag: false,
                            title: "Oops!",
                            message: "Something went wrong, please try again.",
                            transitionIn: "bounceInDown",
                            transitionOut: "fadeOutUp",
                        });
                    },
                });
            }
        });
    });

    $("#viewFeminineModal").on("hidden.bs.modal", function () {
        $(this).find(".modal-body #view_last_periods").empty();
    });

    $(document).find("#assign_feminine").select2({
        placeholder: "Select fiminine to assign",
        tags: false,
    });

    $("#assignFeminineModal").on("show.bs.modal", function (e) {
        $.ajax({
            url: "/health-worker/assign-feminine-list", // Use the correct URL
            type: "GET",
            data: {
                health_worker_id: $(document).find("#health_worker_id").val(), // Corrected selector
            },
            dataType: "json",
            success: function (data) {
                var selectElement = $(document).find("#assign_feminine");
                selectElement.empty();
    
                selectElement.append("<option></option>");
                $.each(data.feminine_list, function (index, feminine) {
                    // Include address in the option text
                    var address = feminine.address ? feminine.address : "No address provided";
                    selectElement.append(
                        '<option value="' +
                            feminine.id +
                            '">' +
                            feminine.full_name +
                            " - " +
                            address +
                            "</option>"
                    );
                });
    
                selectElement.select2({
                    placeholder: "Select feminine to assign",
                    tags: false,
                });
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
    
    $(document).on("click", "#assign_btn", function () {
        var selected_options = $(document).find("#assign_feminine").val();

        if (selected_options && selected_options.length > 0) {
            $.ajax({
                url: "../health-worker/post-assign-feminine",
                type: "POST",
                dataType: "json",
                data: {
                    feminine_id: selected_options,
                    id: $(document).find("#health_worker_id").val(),
                },
                success: function (response) {
                    $("#feminine_table").DataTable().ajax.reload();
                    $("#assignFeminineModal").modal("hide");

                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        position: "topCenter",
                        drag: false,
                        title: "Success!",
                        message: response.message,
                        transitionIn: "bounceInDown",
                        transitionOut: "fadeOutUp",
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Error saving options:", error);
                },
            });
        } else {
            iziToast.error({
                close: false,
                displayMode: 2,
                position: "topCenter",
                drag: false,
                title: "Oops!",
                message: "Please select feminine to assign.",
                transitionIn: "bounceInDown",
                transitionOut: "fadeOutUp",
            });

            return false;
        }
    });
});
