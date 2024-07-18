var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#birthdate_datepicker').datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    orientation: "bottom",
    endDate: '+0d',
});

$(document).on('change', '#birthdate', function(e) {
    if ($(this).hasClass('form-control-danger') || $(document).find('#birthdate_datepicker').hasClass('has-danger')) {
        $(this).removeClass('form-control-danger');
        $(document).find('#birthdate_datepicker').removeClass('has-danger');
        $(document).find('#birthdate-error').remove();
    }
});

$("#sign_up_form").validate({
    onkeyup: function (element) {
        if($(element).attr('name') === 'email') {
            $(element).val() !== ''
                ? $('#contact_no-error').css('display', 'none')
                : $('#contact_no-error').css('display', 'block');
        }

        if($(element).attr('name') === 'contact_no') {
            $(element).val() !== ''
                ? $('#email-error').css('display', 'none')
                : $('#email-error').css('display', 'block');
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
            // required: true,
            email: true,
            required: function (element) {
                return $("#contact_no").val() === "";
            }
        },
        contact_no: {
            digits: true,
            minlength: 10,
            maxlength: 11,
            required: function (element) {
                return $("#email").val() === "";
            }
        },
        menstruation_status: {
            required: true,
        },
        last_period_date: {
            required: true,
            date: true
        },
        password: {
            required: true,
            minlength: 6
        },
        password_confirmation: {
            required: true,
            equalTo: "#password"
        },
        birthdate: {
            required: true,
            date: true,
        }
    },
    messages: {
        first_name: {
            required: "Please enter your first name",
        },
        last_name: {
            required: "Please enter your last name",
        },
        email: {
            required: "Please enter your active email address",
        },
        contact_no: {
            digits: "Please enter a valid contact number",
            minlength: "Must be at least 10 digits",
            maxlength: "Must not exceed 11 digits",
            required: "Please enter your contact number",
        },
        menstruation_status: {
            required: "Please select your current menstruation status",
        },
        password: {
            required: "Please enter your password",
            minlength: "Your password must be at least 6 characters long"
        },
        password_confirmation: {
            required: "Please re-enter your password",
            equalTo: "Your password confirmation must be same as password"
        },
        birthdate: {
            required: "Please enter your birthdate",
            date: "Please enter a valid date"
        }
    },
    errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger');
        label.insertAfter(element);
    },
    highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')
    },
    unhighlight: function (element, errorClass) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
    }
});