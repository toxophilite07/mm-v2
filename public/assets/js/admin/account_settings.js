$(function () {
    'use strict'

    $('#feminine_account_table').DataTable({
        "aLengthMenu": [
            [5, 10, 20, -1],
            [5, 10, 20, "All"]
        ],
        "iDisplayLength": 10,
        "sAjaxSource": "../admin/account-data",
        "columns": [
            { data: 'row_count' },
            { data: 'full_name' },
            { data: 'email' },
            { data: 'user_role_id' },
            { data: 'action' }
        ]
    });
    
    $('#feminine_account_table').each(function () {
        var datatable = $(this);
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        search_input.removeClass('form-control-sm');

        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '.reset_password', function(e) {
        
        Swal.fire({
            title: 'Reset Password',
            html: "Confirm reset password for: <strong>" + $(this).data('full_name') + "</strong>?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirm, reset',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../admin/account-reset',
                    type: 'POST',
                    data: {
                        "id": $(this).data('id'),
                    },
                    success: function (response) {
                        $('#feminine_account_table').DataTable().ajax.reload();
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
        })
    });
});