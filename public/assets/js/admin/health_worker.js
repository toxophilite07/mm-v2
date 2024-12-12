var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$(function () {
    $("#hw_table").DataTable({
        aLengthMenu: [
            [5, 10, 20, -1],
            [5, 10, 20, "All"],
        ],
        iDisplayLength: 10,
        sAjaxSource: "../admin/health-worker-data",
        columns: [
            { data: "row_count" },
            { data: "full_name" },
            { data: "is_active" },
            // { data: "assigning_action" },
            // {data: "address"},
            { data: "is_active_status" },
            { data: "action" },
        ],
    });
    $("#hw_table").each(function () {
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
    $(document).find("#assign_feminine").select2({
        placeholder: "Select fiminine to assign",
        tags: false,
    });

    $(document).on("click", ".verify-hw", function() {
        var userId = $(this).data("id");
        verifyHealthWorker(userId);
    });

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    $("#birthdate_datepicker").datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true,
        autoclose: true,
        forceParse: false,
        endDate: "+0d",
    });

    $("#edit_birthdate_datepicker").datepicker({
        format: "mm/dd/yyyy",
        todayHighlight: true,
        autoclose: true,
        forceParse: false,
        endDate: "+0d",
    });

    $("#birthdate_datepicker").datepicker("setDate", today);

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var validation_options = {
        onkeyup: function (element) {
            if ($(element).attr('id') === 'email_address') {
                $(element).val() !== ''
                    ? $('#contact_no-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#contact_no-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }
            else if($(element).attr('id') === 'edit_email_address') {
                $(element).val() !== ''
                    ? $('#edit_contact_no-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#edit_contact_no-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }

            if ($(element).attr('id') === 'contact_no') {
                $(element).val() !== ''
                    ? $('#email_address-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#email_address-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }
            else if($(element).attr('id') === 'edit_contact_no') {
                $(element).val() !== ''
                    ? $('#edit_email_address-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#edit_email_address-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }

            $(element).valid();
        },
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true,
            },
            email_address: {
                email: true,
                required: function (element) {
                    return $("#contact_no").val() === "";
                }
            },            
            birthdate: {
                required: true,
                date: true,
            },
            contact_no: {
                required: function (element) {
                    return $("#email_address").val() === "";
                },
                digits: true,
                minlength: 10,
                maxlength: 11
            },
            edit_first_name: {
                required: true,
            },
            edit_last_name: {
                required: true,
            },
            edit_email_address: {
                email: true,
                required: function (element) {
                    return $("#edit_contact_no").val() === "";
                }
            },
            edit_contact_no: {
                required: function (element) {
                    return $("#edit_email_address").val() === "";
                },
                digits: true,
                minlength: 10,
                maxlength: 11,
            },
            edit_birthdate: {
                required: true,
                date: true,
            },
        },
        messages: {
            first_name: {
                required: "Please enter a first name",
            },
            last_name: {
                required: "Please enter a last name",
            },
            email_address: {
                required: "Please enter the active email of the user",
            },
            birthdate: {
                required: "birthdate is required",
                date: "Please enter a valid date",
            },
            contact_no: {
                digits: "Please enter a valid contact number",
                minlength: "Must be at least 10 digits",
                maxlength: "Must not exceed 11 digits",
                required: "Please enter your contact number",
            },
            edit_contact_no: {
                digits: "Please enter a valid contact number",
                minlength: "Must be at least 10 digits",
                maxlength: "Must not exceed 11 digits",
                required: "Please enter your contact number",
            },
            edit_email_address: {
                required: "Please enter the active email of the user",
            },
            edit_birthdate: {
                required: "birthdate is required",
                date: "Please enter a valid date",
            },
        },
        errorPlacement: function (label, element) {
            label.addClass("mt-2 text-danger");
            label.insertAfter(element);
        },
        highlight: function (element, errorClass) {
            $(element).parent().addClass("has-danger");
            $(element).addClass("form-control-danger");

            if ($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email_address' || $(element).attr('id') === 'edit_contact_no' || $(element).attr('id') === 'edit_email_address') {
                $(element).closest('.form-group').addClass('has-danger')
            }
        },
        unhighlight: function (element, errorClass) {
            $(element).parent().removeClass("has-danger");
            $(element).removeClass("form-control-danger");

            if ($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email_address' || $(element).attr('id') === 'edit_contact_no' || $(element).attr('id') === 'edit_email_address') {
                $(element).closest('.form-group').removeClass('has-danger')
            }
        },
    };

    $.validator.setDefaults({
        submitHandler: function (content) {
            var action = $(content).find(".action")[0].value;
            var form =
                action == 0
                    ? $("#newHealthWorkerForm")
                    : $("#editHealthWorkerForm");
            var url =
                action == 0
                    ? "../admin/post-health-worker"
                    : "../admin/update-health-worker";
            var modal =
                action == 0
                    ? $("#newHealthWorkerModal")
                    : $("#editHealthWorkerModal");

            postFormRequest(url, $(form)[0], modal);
        },
    });

    $("#newHealthWorkerForm").validate(validation_options);

    
    $("#editHealthWorkerForm").validate(validation_options);

    $("#editHealthWorkerModal").on("show.bs.modal", function (e) {
        var modal = $(this);
        if (e.relatedTarget != null) {
            var button = $(e.relatedTarget);

            modal
                .find(".modal-body #edit_birthdate_datepicker")
                .datepicker("setDate", button.data("birthdate"));

            modal.find(".modal-body #edit_id").val(button.data("id"));
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
        }
    });

    $("#viewHealthWorkerModal").on("show.bs.modal", function (e) {
        var button = $(e.relatedTarget);

        var modal = $(this);
        modal.find(".modal-body #view_name").text(button.data("full_name"));
        modal.find(".modal-body #view_email").text(button.data("email"));
        modal
            .find(".modal-body #view_birthdate")
            .text(button.data("birthdate"));
        modal.find(".modal-body #view_address").text(button.data("address"));
        modal
            .find(".modal-body #view_contact_no")
            .text(`+63${button.data("contact_no")}`);

        modal
            .find(".modal-body #view_is_active")
            .text(button.data("is_active") === 1 ? "• Active" : "• Inactive");          

        var assigned_feminine_list = button.data("assigned_feminine_list");
        if (assigned_feminine_list.length != 0) {
            $.each(assigned_feminine_list, function (i, value) {
                var assigned = $(
                    '<p class="text-muted mt-' +
                        (i == 0 ? "1" : "0") +
                        " mb-0 assigned_" +
                        value.feminine_health_worker_group_id +
                        '">• ' +
                        value.full_name +  ' (' + value.address + ')' +
                        '<i class="fa-solid fa-trash float-right text-danger btn-icon remove_assign" data-id="' +
                        value.feminine_health_worker_group_id +
                        '" role="button"></i></p>'
                );
                modal
                    .find(".modal-body #view_feminnine_assign")
                    .append(assigned);
            });
        } else {
            modal
                .find(".modal-body #view_feminnine_assign")
                .append('<p class="text-muted m-0">• No record found</p>');
        }
    });

    $(document).on("click", ".remove_assign", function () {
        var assign_id = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You want to remove this feminine from the health worker's list?",
            imageUrl: 'https://i.ibb.co/SsYSS95/error.png', // Custom image URL
            imageWidth: 120, // Adjust image width as needed
            imageHeight: 120, // Adjust image height as needed
            imageClass: 'animated-icon', // Add the animation class here
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, remove it!",
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../admin/health-worker/delete-assign-feminine",
                    type: "POST",
                    data: {
                        id: assign_id,
                    },
                    success: function (response) {
                        $(document)
                            .find(".assigned_" + assign_id)
                            .remove();
                        if (response.updated_count == 0)
                            $(document)
                                .find("#view_feminnine_assign")
                                .append(
                                    '<p class="text-muted m-0">• No record found</p>'
                                );

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
                            message: "Something went wrong, please try again.",
                            transitionIn: "bounceInDown",
                            transitionOut: "fadeOutUp",
                        });
                    },
                }).done(function (res) {
                    $("#hw_table").DataTable().ajax.reload();
                });
            }
        });
    });

    $("#assignFeminineModal").on("show.bs.modal", function (e) {
        var button = $(e.relatedTarget);
        var id = $(button).data("id");

        $(document).find("#health_worker_id").val(id);

        $(document)
            .find("#display_health_worker_name")
            .text($(button).data("health_worker_name"));

        $.ajax({
            url: "../admin/health-worder/feminine-list",
            type: "GET",
            data: {
                health_worker_id: $(button).data("id"),
            },
            dataType: "json",
            success: function (data) {
                var selectElement = $(document).find("#assign_feminine");
                selectElement.empty();

                selectElement.append("<option></option>");
                $.each(data.feminine_list, function (index, feminine) {
                    selectElement.append(
                      '<option value="' +
                        feminine.id +
                        '">' +
                        feminine.full_name +
                        ' (' +
                        feminine.address +
                        ')' +
                        "</option>"
                    );
                });

                selectElement.select2({
                    placeholder: "Select fiminine to assign",
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
                url: "../admin/health-worker/post-assign-feminine",
                type: "POST",
                dataType: "json",
                data: {
                    feminine_id: selected_options,
                    id: $(document).find("#health_worker_id").val(),
                },
                success: function (response) {
                    $("#hw_table").DataTable().ajax.reload();
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

    $(document).on("click", ".delete_record", function (e) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            imageUrl: 'https://i.ibb.co/SsYSS95/error.png', // Custom image URL
            imageWidth: 120, // Adjust image width as needed
            imageHeight: 120, // Adjust image height as needed
            imageClass: 'animated-icon', // Add the animation class here
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../admin/delete-health-worker",
                    type: "POST",
                    data: {
                        id: $(this).data("id"),
                    },
                    success: function (response) {
                        $("#hw_table").DataTable().ajax.reload();
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

    function postFormRequest(url, form, modal) {
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                first_name: $(form)[0][1].value,
                middle_name: $(form)[0][2].value,
                last_name: $(form)[0][3].value,
                address: $(form)[0][4].value,
                birthdate: $(form)[0][5].value,
                email: $(form)[0][6].value,
                contact_no: $(form)[0][7].value,
                remarks: $(form)[0][8].value,
                id: $(form)[0][9].value ? $(form)[0][9].value : null,
            },
            success: function (data) {
                if (data) {
                    $("#hw_table").DataTable().ajax.reload();

                    modal.modal("hide");
                    $(form).trigger("reset");

                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        position: "topCenter",
                        drag: false,
                        title: "Success!",
                        message: data.message,
                        transitionIn: "bounceInDown",
                        transitionOut: "fadeOutUp",
                        timeout: 7000, // 7 seconds
                    });
                }
            },
            error: function (err) {
                iziToast.error({
                    close: false,
                    displayMode: 2,
                    position: "topCenter",
                    drag: false,
                    title: "Oops!",
                    message: "Something went wrong, please try again.",
                    message: err.responseJSON.message,
                    transitionIn: "bounceInDown",
                    transitionOut: "fadeOutUp",
                });

            },
        });
    }
});

$(document).on("click", ".verify_account", function (e) {
    var id = $(this).data("id");
    var full_name = $(this).data("full_name");
    
    Swal.fire({
        title: "Confirmation",
        html: "Confirm and verify <strong>" + full_name + "'s</strong> account!",
        imageUrl: 'https://i.ibb.co/vQ4p98t/question.png', // Custom image URL
        imageWidth: 120, // Adjust image width as needed
        imageHeight: 120, // Adjust image height as needed
        imageClass: 'animated-icon', // Add the animation class here
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirm",
        allowOutsideClick: false,
        allowEscapeKey: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/confirm-health-worker",
                type: "POST",
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $("#hw_table").DataTable().ajax.reload(); // Reload the DataTable
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
                    var errorMessage = xhr.responseJSON.message;
                    iziToast.error({
                        close: false,
                        displayMode: 2,
                        position: "topCenter",
                        drag: false,
                        title: "Error!",
                        message: errorMessage,
                        transitionIn: "bounceInDown",
                        transitionOut: "fadeOutUp",
                    });
                },
            });
        }
    });
});

$("#newHealthWorkerModal").on("shown.bs.modal", function () {
    $("#newHealthWorkerForm").trigger("reset");
    $("#birthdate_datepicker").datepicker("setDate", today);
});

$("#newHealthWorkerModal").on("hidden.bs.modal", function () {
    $("#newHealthWorkerForm").trigger("reset");
});

$("#viewHealthWorkerModal").on("hidden.bs.modal", function () {
    $(this).find(".modal-body #view_feminnine_assign").empty();
});




