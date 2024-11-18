$(function () {
    'use strict';

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

                        // Clear form and validation on modal close
                        $('#editFeminineModal').modal('hide');
                        $("#editFeminineModal").on("hidden.bs.modal", function () {
                            form.trigger("reset")
                                .find(".form-control")
                                .removeClass("form-control-danger valid")
                                .removeAttr("aria-invalid")
                                .end()
                                .find(".form-group")
                                .removeClass("has-danger");
                            form.validate().resetForm();
                        });

                        // Reset date picker
                        $('#edit_last_period_datepicker').datepicker('setDate', null);

                        // Display success message
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

                        // Close modal
                        $('#editFeminineModal').modal('hide');
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
            $(element).valid();
        },
        rules: {
            edit_first_name: { required: true },
            edit_last_name: { required: true },
            address: {
                required: true,
                validateAddress: true // Added the custom validation here
            },
            edit_email_address: { email: true },
            edit_menstruation_status: { required: true },
            last_period_date: { required: true, date: true },
            birthdate: { required: true, date: true },
            edit_contact_no: { digits: true, minlength: 10, maxlength: 11 }
        },
        messages: {
            edit_first_name: { required: "Please enter a first name" },
            edit_last_name: { required: "Please enter a last name" },
            address: {
                required: "Please enter your address",
                validateAddress: "Please enter a valid address in Madridejos "
                },
            edit_email_address: { email: "Please enter a valid email address" },
            edit_menstruation_status: { required: "Please select the current menstruation status of the user" },
            last_period_date: { required: "Please select the last known period date of the user" },
            birthdate: { required: "Please select the birthdate of the user", date: "Please enter a valid date" },
            edit_contact_no: {
                digits: "Please enter a valid contact number",
                minlength: "Must be at least 10 digits",
                maxlength: "Must not exceed 11 digits"
            }
        },
        errorPlacement: function (label, element) {
            label.addClass('mt-2 text-danger');
            label.insertAfter(element);
        },
        highlight: function (element) {
            $(element).parent().addClass('has-danger');
            $(element).addClass('form-control-danger');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('has-danger');
            $(element).removeClass('form-control-danger');
        }
    });
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
