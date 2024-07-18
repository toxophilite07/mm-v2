$(function () {
    'use strict'
    
    $.validator.setDefaults({
        submitHandler: function () {

            var form = $('#editFeminineForm');

            $.ajax({
                url: '../health-worker/update-feminine',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: form.find('#edit_id').val(),
                    edit_menstruation_period_id: form.find('#edit_menstruation_period_id').val(),
                    first_name: form.find('#edit_first_name').val(),
                    last_name: form.find('#edit_last_name').val(),
                    address: form.find('#edit_address').val(),
                    middle_name: form.find('#edit_middle_name').val(),
                    email: form.find('#edit_email_address').val(),
                    contact_no: form.find('#edit_contact_no').val(),
                    birthdate: form.find('#edit_birthdate').val(),
                    menstruation_status: form.find('#edit_menstruation_status').val(),
                    last_period_date: form.find('#edit_last_period_date').val(),
                    remarks: form.find('#edit_remarks').val(),
                },
                success: function (data) {
                    if (data) {
                        $('#feminine_table').DataTable().ajax.reload();

                        $('#editFeminineModal').modal('hide');
                        $('#editFeminineForm').trigger('reset');

                        $('#edit_last_period_datepicker').datepicker('setDate', null);

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
                error: function () {
                    iziToast.error({
                        close: false,
                        displayMode: 2,
                        position: 'topCenter',
                        drag: false,
                        title: 'Oops!',
                        message: 'Something went wrong, please try again.',
                        transitionIn: 'bounceInDown',
                        transitionOut: 'fadeOutUp',
                    });
                }
            });
        }
    });

    $("#editFeminineForm").validate({
        onkeyup: function (element) {
            if ($(element).attr('id') === 'edit_email_address') {
                $(element).val() !== ''
                    ? $('#edit_contact_no-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#edit_contact_no-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }

            if ($(element).attr('id') === 'edit_contact_no') {
                $(element).val() !== ''
                    ? $('#edit_email_address-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                    : $('#edit_email_address-error').css('display', 'block').closest('.form-group').addClass('has-danger');
            }

            $(element).valid();
        },
        rules: {
            edit_first_name: {
                required: true,
            },
            edit_last_name: {
                required: true,
            },
            edit_email_address: {
                required: function (element) {
                    return $("#edit_contact_no").val() === "";
                },
                email: true
            },
            edit_menstruation_status: {
                required: true,
            },
            last_period_date: {
                required: true,
                date: true
            },
            birthdate: {
                required: true,
                date: true
            },
            edit_contact_no: {
                required: function (element) {
                    return $("#edit_email_address").val() === "";
                },
                digits: true,
                minlength: 10,
                maxlength: 11
            }
        },
        messages: {
            edit_first_name: {
                required: "Please enter a first name",
            },
            edit_last_name: {
                required: "Please enter a last name",
            },
            edit_email_address: {
                required: "Please enter the active email of the user",
            },
            edit_menstruation_status: {
                required: "Please select the current menstruation status of the user",
            },
            last_period_date: {
                required: "Please select the last known period date of the user",
            },
            birthdate: {
                required: "Please select the birthdate of the user",
                date: "Please enter a valid date"
            },
            edit_contact_no: {
                digits: "Please enter a valid contact number",
                minlength: "Must be at least 10 digits",
                maxlength: "Must not exceed 11 digits",
                required: "Please enter your contact number"
            }
        },
        errorPlacement: function (label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function (element, errorClass) {
            $(element).parent().addClass('has-danger')
            $(element).addClass('form-control-danger')

            if ($(element).attr('id') === 'edit_contact_no' || $(element).attr('id') === 'edit_email_address') {
                $(element).closest('.form-group').addClass('has-danger')
            }
        },
        unhighlight: function (element, errorClass) {
            $(element).parent().removeClass('has-danger');
            $(element).removeClass('form-control-danger');

            if ($(element).attr('id') === 'edit_contact_no' || $(element).attr('id') === 'edit_email_address') {
                $(element).closest('.form-group').removeClass('has-danger')
            }
        }
    });
})