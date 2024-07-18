var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$("#edit_last_period_datepicker").datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    forceParse: false,
});

$("#edit_birthdate_datepicker").datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    forceParse: false,
    endDate: "+0d",
});

$(function () {
    "use strict";

    $(function () {
        $("#feminine_table").DataTable({
            aLengthMenu: [
                [5, 10, 20, -1],
                [5, 10, 20, "All"],
            ],
            iDisplayLength: 10,
            sAjaxSource: "../admin/feminine-data",
            columns: [
                { data: "row_count" },
                { data: "full_name" },
                { data: "menstruation_status" },
                { data: "is_assigned" },
                { data: "is_active" },
                { data: "action" },
            ],
            fnInitComplete: function (oSettings, json) {
                var urlParams = new URLSearchParams(window.location.search);

                if (urlParams.has("q")) {
                    $(document)
                        .find("#notif_" + urlParams.get("q"))
                        .trigger("click");

                    urlParams.delete("q");

                    var newUrl = window.location.pathname;
                    if (urlParams.toString() !== "")
                        newUrl += "?" + urlParams.toString();
                    history.replaceState(null, "", newUrl);
                }

                if (urlParams.has("p")) {
                    $(document)
                        .find("#period_notif_" + urlParams.get("p"))
                        .trigger("click");

                    urlParams.delete("p");

                    var newUrl = window.location.pathname;
                    if (urlParams.toString() !== "")
                        newUrl += "?" + urlParams.toString();
                    history.replaceState(null, "", newUrl);
                }
            },
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

    $("#viewFeminineModal").on("show.bs.modal", function (e) {
        var button = $(e.relatedTarget);
        var last_period_dates = button.data("last_period_dates");
        var assigned_bhw = button.data("assign_bhw");

        var modal = $(this);

        if (assigned_bhw.length != 0) {
            modal
                .find(".modal-body #view_assigned_health_worker")
                .empty()
                .append(assigned_bhw);
        } else {
            modal
                .find(".modal-body #view_assigned_health_worker")
                .empty()
                .append(
                    '<p class="text-muted m-0">• No assigned health worker yet</p>'
                );
        }

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
            });
        } else {
            modal
                .find(".modal-body #view_last_periods")
                .append('<p class="text-muted m-0">• No record found</p>');
        }
    });

    $(document).on("click", ".verify_account", function (e) {
        var id = $(this).data("id");
        var full_name = $(this).data("full_name");

        Swal.fire({
            title: "Confirmation",
            html:
                "Confirm and verify <strong>" +
                full_name +
                "'s</strong> account!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Confirm",
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../admin/confirm-feminine",
                    type: "POST",
                    data: {
                        id: id,
                    },
                    success: function (response) {
                        $(document)
                            .find("#notification_body_" + id)
                            .remove();
                        $("#feminine_table").DataTable().ajax.reload();
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
                    error: function (response) {
                        iziToast.error({
                            close: false,
                            displayMode: 2,
                            position: "topCenter",
                            drag: false,
                            title: "Oops!",
                            message: response.message,
                            transitionIn: "bounceInDown",
                            transitionOut: "fadeOutUp",
                        });
                    },
                }).done(function (response) {
                    if (response.new_notification_count == 0) {
                        $(document)
                            .find("#notification_indicator")
                            .addClass("hidden");
                        $(document)
                            .find(".notification_count")
                            .text("No Notifications");
                        $(document)
                            .find("#notification_container")
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
                            .find(".notification_count")
                            .text(
                                response.new_notification_count +
                                    " New Notifications"
                            );
                    }
                });
            }
        });
    });

    $(document).on("click", ".delete_record", function (e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../admin/delete-feminine",
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
                            message: "Record has been successfully removed.",
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

    $("#editFeminineModal").on("show.bs.modal", function (e) {
        var modal = $(this);

        // initiate a condition to check if the relatedTarget is null
        // for some reason this temporarily fix the bootstrap-datepicker bug, when clicking the datepicker it clears the other input fields
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

    $("#editFeminineModal").on("hidden.bs.modal", function (e) {
        const form = $(this).find("#editFeminineForm");
        form.trigger("reset")
            .find(".form-control")
            .removeClass("form-control-danger valid")
            .removeAttr("aria-invalid")
            .end()
            .find(".form-group")
            .removeClass("has-danger");
        form.validate().resetForm();
    });

    $("#viewFeminineModal").on("hidden.bs.modal", function () {
        $(this).find(".modal-body #view_last_periods").empty();
    });
});
