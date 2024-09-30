var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#birthdate_datepicker').datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    orientation: "bottom",
    endDate: '+0d',
});

// Remove error classes and messages on change
$(document).on('change', '#birthdate', function (e) {
    if ($(this).hasClass('form-control-danger') || $(document).find('#birthdate_datepicker').hasClass('has-danger')) {
        $(this).removeClass('form-control-danger');
        $(document).find('#birthdate_datepicker').removeClass('has-danger');
        $(document).find('#birthdate-error').remove();
    }
});

// Add custom validator for Gmail addresses
$.validator.addMethod("validateGmail", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._%+-]+@gmail\.com$/.test(value);
}, "The email must be a valid Gmail address (nelbanbetache@gmail.com)");

// Add custom validator for names
$.validator.addMethod("validateName", function (value, element) {
    return this.optional(element) || /^[a-zA-Z\s]+$/.test(value); // Only allows letters and spaces
}, "Please enter a valid name (letters only)");

// Add custom validator for address
$.validator.addMethod("validateAddress", function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9\s.,-]+$/.test(value); // Allows letters, numbers, spaces, and some punctuation
}, "Please enter a valid address (Tarong Madridejos Cebu)");

// Add custom validator for invalid input
$.validator.addMethod("noInvalidChars", function (value, element) {
    return this.optional(element) || !/(....)/.test(value); // Adjust pattern as needed
}, "Invalid input detected");

// Add custom validator for password strength
$.validator.addMethod("strongPassword", function (value, element) {
    return this.optional(element) || (/[A-Z]/.test(value) && 
                                       /[a-z]/.test(value) && 
                                       /[0-9]/.test(value) && 
                                       /[@$!%*#?&]/.test(value));
}, "Your password must include at least one uppercase letter, one lowercase letter, one number, and one special character.");

// Password strength indicator
$('#password').on('input', function() {
    var password = $(this).val();
    var strength = 'Weak';
    if (password.length >= 8 && /[A-Z]/.test(password) && /[a-z]/.test(password) && /[0-9]/.test(password) && /[@$!%*#?&]/.test(password)) {
        strength = 'Strong';
    } else if (password.length >= 8) {
        strength = 'Moderate';
    }
    $('#password-strength').text(strength);
});

$("#sign_up_form").validate({
    onkeyup: function (element) {
        if ($(element).attr('name') === 'email') {
            $(element).val() !== ''
                ? $('#contact_no-error').css('display', 'none')
                : $('#contact_no-error').css('display', 'block');
        }

        if ($(element).attr('name') === 'contact_no') {
            $(element).val() !== ''
                ? $('#email-error').css('display', 'none')
                : $('#email-error').css('display', 'block');
        }

        $(element).valid();
    },
    rules: {
        first_name: {
            required: true,
            validateName: true, // Add name validation
        },
        middle_name: {
            required: false, // Optional middle name
            validateName: true, // Add name validation
        },
        last_name: {
            required: true,
            validateName: true, // Add name validation
        },
        address: {
            required: true,
            validateAddress: true, // Add address validation
        },
        email: {
            required: function (element) {
                return $("#contact_no").val() === ""; // Email is required if contact_no is empty
            },
            email: true,
            validateGmail: true // Custom method for Gmail validation
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
            minlength: 8,
            strongPassword: true // Add password strength validation
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
            validateName: "Please enter a valid first name (Nelban)"
        },
        middle_name: {
            validateName: "Please enter a valid middle name (Bais)"
        },
        last_name: {
            required: "Please enter your last name",
            validateName: "Please enter a valid last name (Betache)"
        },
        address: {
            required: "Please enter your address",
            validateAddress: "Please enter a valid address (Tarong Madridejos Cebu )"
        },
        email: {
            required: "Please enter your active email address",
            email: "Please enter a valid email address",
            validateGmail: "The email must be a valid Gmail address (nelbanbetache@gmail.com)"
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
            minlength: "Your password must be at least 8 characters long",
            strongPassword: "Your password must include at least one uppercase letter, one lowercase letter, one number, and one special character."
        },
        password_confirmation: {
            required: "Please re-enter your password",
            equalTo: "Your password confirmation must be the same as the password"
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


///Password Sterength Indacator
$(document).ready(function () {
    $('#password').on('input', function () {
        const password = $(this).val();
        let strength = '';

        // Password strength criteria
        const strongPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        const moderatePassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

        // Check password strength
        if (password.length === 0) {
            strength = ''; // No strength
        } else if (strongPassword.test(password)) {
            strength = 'strong';
        } else if (moderatePassword.test(password)) {
            strength = 'moderate';
        } else {
            strength = 'weak';
        }

        // Update the strength indicator
        updateStrengthIndicator(strength);
    });

    function updateStrengthIndicator(strength) {
        const strengthIndicator = $('#password-strength-indicator');

        // Reset the indicator styles
        strengthIndicator.removeClass('weak moderate strong'); // Remove previous classes
        strengthIndicator.css('width', ''); // Reset width
        strengthIndicator.css('background-color', 'transparent'); // Make it transparent

        // Update the indicator based on strength
        if (strength === 'weak') {
            strengthIndicator.addClass('weak');
            strengthIndicator.css('width', '33%'); // Weak strength
            strengthIndicator.css('background-color', 'rgba(255, 0, 0, 0.7)'); // Red
        } else if (strength === 'moderate') {
            strengthIndicator.addClass('moderate');
            strengthIndicator.css('width', '66%'); // Moderate strength
            strengthIndicator.css('background-color', 'rgba(255, 165, 0, 0.7)'); // Orange
        } else if (strength === 'strong') {
            strengthIndicator.addClass('strong');
            strengthIndicator.css('width', '100%'); // Strong strength
            strengthIndicator.css('background-color', 'rgba(0, 128, 0, 0.7)'); // Green
        } else {
            // If no strength, reset to transparent
            strengthIndicator.css('background-color', 'transparent'); // Make it invisible
        }
    }
});
