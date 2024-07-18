$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.validator.setDefaults({
    submitHandler: function () {

        var form = $('#password_form');

        $.ajax({
            url: '../health-worker/change-password',
            type: 'POST',
            dataType: 'json',
            data: {
                id: form.find('#uid').val(),
                old_password: form.find('#old_password').val(),
                new_password: form.find('#new_password').val(),
                new_password_confirmation: form.find('#new_password_confirmation').val(),
            },
            success: function (data) {
                if (data) {
                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        drag: false,
                        position: 'topCenter',
                        title: 'Success!',
                        message: data.message,
                        transitionIn: 'bounceInDown',
                        transitionOut: 'fadeOutUp',
                    });
                }
            },
            error: function (response) {
                iziToast.error({
                    close: false,
                    displayMode: 2,
                    position: 'topCenter',
                    drag: false,
                    title: 'Oops!',
                    message: response.responseJSON ? response.responseJSON.message : 'Something went wrong, please try again.',
                    transitionIn: 'bounceInDown',
                    transitionOut: 'fadeOutUp',
                });
            }
        }).done(function (data) {
            if (data.success == true) {
                form.find('#old_password').val('');
                form.find('#new_password').val('');
                form.find('#new_password_confirmation').val('');

                form.find('.has-danger').removeClass('has-danger');
            }
        });
    }
});

$("#password_form").validate({
    rules: {
        old_password: {
            required: true,
        },
        new_password: {
            required: true,
            minlength: 6,
        },
        new_password_confirmation: {
            required: true,
            minlength: 6,
            equalTo: "#new_password"
        }
    },
    messages: {
        old_password: {
            required: "Please enter your current password.",
        },
        new_password: {
            required: "Please enter your new password.",
            minlength: "Your password must be at least 6 characters long."
        },
        new_password_confirmation: {
            required: "Please confirm your new password.",
            minlength: "Your password must be at least 6 characters long.",
            equalTo: "Your password does not match."
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