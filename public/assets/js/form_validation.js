var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#last_period_datepicker').datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    endDate: '+0d',
});

$('#birthdate_datepicker').datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    endDate: '+0d',
});

$('#last_period_datepicker').datepicker('setDate', today);
$('#birthdate_datepicker').datepicker('setDate', today);

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.validator.setDefaults({
    submitHandler: function () {

        var form = $('#newFeminineForm');

        $.ajax({
            url: '../admin/new-feminine',
            type: 'POST',
            dataType: 'json',
            data: {
                first_name: form.find('#first_name').val(),
                last_name: form.find('#last_name').val(),
                middle_name: form.find('#middle_name').val(),
                address: form.find('#address').val(),
                email: form.find('#email_address').val(),
                contact_no: form.find('#contact_no').val(),
                birthdate: form.find('#birthdate').val(),
                menstruation_status: form.find('#menstruation_status').val(),
                last_period_date: form.find('#last_period_date').val(),
                remarks: form.find('#remarks').val(),
            },
            success: function (data) {
                if(data) {
                    $('#feminine_count').text(data.feminine_count.feminine_count);
                    $('#active_feminine_count').text(data.feminine_count.active_feminine_count);
                    $('#inactive_feminine_count').text(data.feminine_count.inactive_feminine_count);

                    if (window.location.href.includes('admin/feminine-list')) {
                        $('#feminine_table').DataTable().ajax.reload();
                    }
                    
                    $('#newFeminineModal').modal('hide');
                    $('#newFeminineForm').trigger('reset');

                    $('#last_period_datepicker').datepicker('setDate', today);

                    iziToast.success({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        position: 'topCenter',
                        drag: false,
                        title: 'Success!',
                        message: data.message,
                        transitionIn: 'bounceInDown',
                        transitionOut: 'fadeOutUp',
                        timeout: 7000 // 7 seconds
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
                    message: 'Something went wrong, please try again.',
                    transitionIn: 'bounceInDown',
                    transitionOut: 'fadeOutUp',
                });
            }
        });
    }
});

$("#newFeminineForm").validate({
    onkeyup: function (element) {
        if($(element).attr('id') === 'email_address') {
            $(element).val() !== ''
                ? $('#contact_no-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                : $('#contact_no-error').css('display', 'block').closest('.form-group').addClass('has-danger');
        }

        if($(element).attr('id') === 'contact_no') {
            $(element).val() !== ''
                ? $('#email_address-error').css('display', 'none').closest('.form-group').removeClass('has-danger')
                : $('#email_address-error').css('display', 'block').closest('.form-group').addClass('has-danger');
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
        menstruation_status: {
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
        contact_no: {
            required: function (element) {
                return $("#email_address").val() === "";
            },
            digits: true,
            minlength: 10,
            maxlength: 11
        }
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
        menstruation_status: {
            required: "Please select the current menstruation status of the user",
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
        }
    },
    errorPlacement: function (label, element) {
        label.addClass('mt-2 text-danger');
        label.insertAfter(element);
    },
    highlight: function (element, errorClass) {
        $(element).parent().addClass('has-danger')
        $(element).addClass('form-control-danger')

        if($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email_address') {
            $(element).closest('.form-group').addClass('has-danger')
        }
    },
    unhighlight: function (element, errorClass) {
        $(element).parent().removeClass('has-danger');
        $(element).removeClass('form-control-danger');
        
        if($(element).attr('id') === 'contact_no' || $(element).attr('id') === 'email_address') {
            $(element).closest('.form-group').removeClass('has-danger')
        }
    }
});

$('#newFeminineModal').on('shown.bs.modal', function () {
    $('#newFeminineForm').trigger('reset');
    $('#last_period_datepicker').datepicker('setDate', today);
    $('#birthdate_datepicker').datepicker('setDate', today);
});

$('#newFeminineModal').on('hidden.bs.modal', function () {

    const form = $(this).find('#newFeminineForm');
    form.trigger('reset')
        .find('.form-control')
        .removeClass('form-control-danger valid')
        .removeAttr('aria-invalid')
        .end()
        .find('.form-group')
        .removeClass('has-danger');
    form.validate().resetForm();

    $('#last_period_datepicker').datepicker('setDate', today);
});
