$("#birthdate_datepicker").datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    endDate: "+0d",
});

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$.validator.addMethod("gmailOnly", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(value);
}, "Only Gmail addresses are allowed (example: nelbanbetache@gmail.com).");

$("#profile_form").validate({
    rules: {
        email: {
            email: true,
            gmailOnly: true
        }
    },
    messages: {
        email: {
            email: "Please enter a valid email address.",
            gmailOnly: "Only Gmail addresses are allowed (example: nelbanbetache@gmail.com)."
        }
    },
    errorPlacement: function (error, element) {
        error.css({
            "color": "red",
            "font-weight": "bold"
        });
        error.insertAfter(element);
    },
    submitHandler: function () {
        var form = $("#profile_form");

        $.ajax({
            url: "../health-worker/update-profile",
            type: "POST",
            dataType: "json",
            data: {
                id: form.find("#id").val(),
                first_name: form.find("#first_name").val(),
                last_name: form.find("#last_name").val(),
                middle_name: form.find("#middle_name").val(),
                email: form.find("#email").val(),
                contact_no: form.find("#contact_no").val(),
                address: form.find("#address").val(),
                birthdate: form.find("#birthdate").val(),
                remarks: form.find("#remarks").val(),
            },
            success: function (data) {
                if (data) {
                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        drag: false,
                        position: "topCenter",
                        title: "Success!",
                        message: data.message,
                        transitionIn: "bounceInDown",
                        transitionOut: "fadeOutUp",
                    });
                }
            },
            error: function (res) {
                iziToast.error({
                    close: false,
                    displayMode: 2,
                    position: "topCenter",
                    drag: false,
                    title: "Oops!",
                    message: res.responseJSON.message,
                    transitionIn: "bounceInDown",
                    transitionOut: "fadeOutUp",
                });
            },
        });
    }
});


$("#profile_form").validate({
    onkeyup: function (element) {
        if ($(element).attr('id') === 'email') {
            $(element).val() !== ''
                ? $('#contact_no-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                : $('#contact_no-error').css('display', 'block').closest('.form-group').addClass('has-danger');
        }

        if ($(element).attr('id') === 'contact_no') {
            $(element).val() !== ''
                ? $('#email-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                : $('#email-error').css('display', 'block').closest('.form-group').addClass('has-danger');
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
        email: {
            email: true,
            required: function (element) {
                return $("#contact_no").val() === "";
            }
        },
        address: {
            required: true,
            validateAddress: true // Added the custom validation here
        },
        birthdate: {
            required: true,
            date: true,
        },
        contact_no: {
            required: function (element) {
                return $("#email").val() === "";
            },
            digits: true,
            minlength: 10,
            maxlength: 11,
        },
    },
    messages: {
        first_name: {
            required: "Please enter a first name",
        },
        last_name: {
            required: "Please enter a last name",
        },
        email: {
            required: "Please enter the active email of the user",
        },
        address: {
            required: "Please enter your address",
            validateAddress: "Please enter a valid address in Madridejos "
            },
        birthdate: {
            required: "Please select the birthdate of the user",
            date: "Please enter a valid date",
        },
        contact_no: {
            digits: "Please enter a valid contact number",
            minlength: "Must be at least 10 digits",
            maxlength: "Must not exceed 11 digits",
            required: "Please enter your contact number"
        },
    },
    errorPlacement: function (label, element) {
        label.addClass("mt-2 text-danger");
        label.insertAfter(element);
    },
    highlight: function (element, errorClass) {
        $(element).parent().addClass("has-danger");
        $(element).addClass("form-control-danger");

        if ($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email') {
            $(element).closest('.form-group').addClass('has-danger')
        }
    },
    unhighlight: function (element, errorClass) {
        $(element).parent().removeClass("has-danger");
        $(element).removeClass("form-control-danger");

        if ($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email') {
            $(element).closest('.form-group').removeClass('has-danger')
        }
    },
});
$.validator.addMethod("validateAddress", function (value, element) {
    var validAddresses = [
        "Tarong Madridejos Cebu", "Bunakan Madridejos Cebu", "Kangwayan Madridejos Cebu", 
        "Kaongkod Madridejos Cebu", "Kodia Madridejos Cebu", "Maalat Madridejos Cebu", 
        "Malbago Madridejos Cebu", "Mancilang Madridejos Cebu", "Pili Madridejos Cebu", 
        "Poblacion Madridejos Cebu", "San Agustin Madridejos Cebu", "Tabagak Madridejos Cebu", 
        "Talangnan Madridejos Cebu", "Tugas Madridejos Cebu"
    ];
    return validAddresses.includes(value);
}, "Please enter a valid address in Madridejos.");
