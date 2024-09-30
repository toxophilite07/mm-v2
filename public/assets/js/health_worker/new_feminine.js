var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

// $("#last_period_datepicker").datepicker({
//     format: "mm/dd/yyyy",
//     todayHighlight: true,
//     autoclose: true,
//     endDate: "+0d",
// });

// $("#birthdate_datepicker").datepicker({
//     format: "mm/dd/yyyy",
//     todayHighlight: true,
//     autoclose: true,
//     endDate: "+0d",
// });

// $("#last_period_datepicker").datepicker("setDate", today);
// $("#birthdate_datepicker").datepicker("setDate", today);

$("#last_period_datepicker").datepicker({
    format: "mm/dd/yyyy",
    autoclose: true,
    endDate: "+0d"
}).datepicker("setDate", null); // Ensure no date is set initially

$("#birthdate_datepicker").datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    endDate: "+0d"
}).datepicker("setDate", today); // Optionally set today's date

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// Custom validation method to ensure at least one of the fields is filled if provided
$.validator.addMethod("eitherOr", function (value, element, params) {
    var otherElement = $(params).val();
    return !value || !otherElement || (value && otherElement); // Either both or neither can be filled
}, "Please provide either email or contact number if one is provided.");

$.validator.setDefaults({
    submitHandler: function (form) {
        var formData = $(form).serialize(); // Serialize form data

        $.ajax({
            url: "../health-worker/new-feminine",
            type: "POST",
            dataType: "json",
            data: formData,
            success: function (data) {
                if (data) {
                    $("#feminine_count").text(data.feminine_count.feminine_count);
                    $("#active_feminine_count").text(data.feminine_count.active_feminine_count);
                    $("#inactive_feminine_count").text(data.feminine_count.inactive_feminine_count);

                    $("#feminine_table").DataTable().ajax.reload();
                    $("#newFeminineModal").modal("hide");
                    $("#newFeminineForm").trigger("reset");
                    $("#last_period_datepicker").datepicker("setDate", today);

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
                        timeout: 7000,
                    });
                }
            },
            error: function () {
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
    },
});

$("#newFeminineForm").validate({
    onkeyup: function (element) {
        $(element).valid();
    },
    rules: {
        first_name: {
            required: true,
        },
        last_name: {
            required: true,
        },
        address: {
            required: true,
        },
        email_address: {
            email: true, // Email format validation
            // No 'required' rule, but must be valid if provided
        },
        menstruation_status: {
            required: true,
        },
        last_period_date: {
            required: true,
            date: true,
        },
        birthdate: {
            required: true,
            date: true,
        },
        contact_no: {
            digits: true,
            minlength: 10,
            maxlength: 11,
            // No 'required' rule, but must be valid if provided
        }
    },
    messages: {
        first_name: {
            required: "Please enter a first name",
        },
        last_name: {
            required: "Please enter a last name",
        },
        address: {
            required: "Please enter a valid  address",
        },
        email_address: {
            email: "Please enter a valid email address",
        },
        menstruation_status: {
            required: "Please select the current menstruation status of the user",
        },
        last_period_date: {
            required: "Please provide last menstruation date",
            date: true,
        },
        birthdate: {
            required: "Please select the birthdate of the user",
            date: "Please enter a valid date",
        },
        contact_no: {
            digits: "Please enter a valid contact number",
            minlength: "Must be at least 10 digits",
            maxlength: "Must not exceed 11 digits",
        }
    },
    errorPlacement: function (label, element) {
        label.addClass("mt-2 text-danger");
        label.insertAfter(element);
    },
    highlight: function (element, errorClass) {
        $(element).parent().addClass("has-danger");
        $(element).addClass("form-control-danger");
    },
    unhighlight: function (element, errorClass) {
        $(element).parent().removeClass("has-danger");
        $(element).removeClass("form-control-danger");
    }
});

// $("#newFeminineModal").on("shown.bs.modal", function () {
//     $("#newFeminineForm").trigger("reset");
//     $("#last_period_datepicker").datepicker("setDate", today);
//     $("#birthdate_datepicker").datepicker("setDate", today);
// });

// $("#newFeminineModal").on("hidden.bs.modal", function () {
//     $("#newFeminineForm").trigger("reset");
//     $("#last_period_datepicker").datepicker("setDate", today);
// });

$("#newFeminineModal").on("shown.bs.modal", function () {
    $("#newFeminineForm").trigger("reset"); // Reset the form
    $("#last_period_date").val(''); // Clear the date input value
    $("#last_period_datepicker").datepicker("setDate", null); // Update datepicker to clear date
});

$("#newFeminineModal").on("hidden.bs.modal", function () {
    $("#newFeminineForm").trigger("reset"); // Reset the form
    $("#last_period_date").val(''); // Clear the date input value
    $("#last_period_datepicker").datepicker("setDate", null); // Update datepicker to clear date
});

$("#newFeminineForm").on("reset", function () {
    $("#last_period_date").val(''); // Clear the date input value
    $("#last_period_datepicker").datepicker("setDate", null); // Update datepicker to clear date
});
