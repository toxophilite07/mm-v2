$(function () {
    $('#menstrual_table').DataTable({
        "aLengthMenu": [
            [5, 10, 20, -1],
            [5, 10, 20, "All"]
        ],
        "iDisplayLength": 10,
        "sAjaxSource": "../user/menstrual-data",
        "columns": [
            { data: 'row_count' },
            { data: 'menstruation_date' },
            { data: 'remarks' },
            { data: 'action' }
        ]
    });
    $('#menstrual_table').each(function () {
        var datatable = $(this);
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');

        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});

$(document).on('click', '.edit_menstrual', function (e) {
    $('#menstrualPeriodModal').modal('show');

    $(document).find('#form_action').val(1);

    var button = $(this);
    $(document).find('#menstruation_period_id').val(button.data('id'));
    // $(document).find('#menstruation_period').val(button.data('menstruation_period'));
    $(document).find('#menstruation_period_datepicker').datepicker('setDate', button.data('menstruation_period'));
    $(document).find('#remarks').val(button.data('remarks'));
});

$(document).on('click', '.delete_menstrual', function (e) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        allowOutsideClick: false,
        allowEscapeKey: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../user/delete-menstruation-period',
                type: 'POST',
                data: {
                    "id": $(this).data('id'),
                },
                success: function (response) {
                    $('#menstrual_table').DataTable().ajax.reload();
                    iziToast.info({
                        close: false,
                        displayMode: 2,
                        layout: 2,
                        position: 'topCenter',
                        drag: false,
                        title: 'Success!',
                        message: response.message,
                        transitionIn: 'bounceInDown',
                        transitionOut: 'fadeOutUp',
                    });
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
    })
});