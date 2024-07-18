var calendar_period;
$(document).ready(function () {
    if(window.location.href.includes('user/dashboard')) {
        getFullCalendar();
    }
});

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

$('#menstruation_period_datepicker').datepicker({
    format: "mm/dd/yyyy",
    todayHighlight: true,
    autoclose: true,
    endDate: '+0d',
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.validator.setDefaults({
    submitHandler: function () {

        var form = $('#menstrualPeriodForm');
        var post_url = (
            window.location.href.includes('user/dashboard') || $(document).find('#form_action').val().length == 0
                ? '../user/post-menstruation-period'
                : '../user/update-menstruation-period'
        );

        $.ajax({
            url: post_url,
            type: 'POST',
            dataType: 'json',
            data: {
                id: form.find('#id').val(),
                menstruation_period_id: form.find('#menstruation_period_id').val(),
                menstruation_period: form.find('#menstruation_period').val(),
                remarks: form.find('#remarks').val(),
            },
            success: function (data) {
                if(data) {
                    if(window.location.href.includes('user/dashboard')) {
                        if (!$(document).find('.external-events-listing').hasClass('hidden')) {
                            getFullCalendar();
                        }
                        else {
                            calendar_period.fullCalendar('destroy');
                            getFullCalendar();
                        }

                        $('#menstruation_period_count').text(data.menstruation_period_count);
                        $('#latest_period_date').text(data.latest_period_date);
                    }
                    else if (window.location.href.includes('user/menstrual')) {
                        $('#menstrual_table').DataTable().ajax.reload();
                    }

                    $('#menstrualPeriodModal').modal('hide');
                    $('#menstrualPeriodForm').trigger('reset');

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
        }).done(function (data) {
            if(data.menstruation_period_count != 0 && window.location.href.includes('user/dashboard')) {
                var time_line_container = $(document).find('#external-events-listing');
                    time_line_container.empty().removeClass('hidden');

                $(document).find('.timeline_no_record').addClass('hidden');

                time_line_container.append('\
                    <p class="mb-1">Next Estimated Menstrual Date</p>\
                    <div class="fc-event estimated_period ml-2" >'+ data.estimated_next_period +'</div>\
                    <p class="mb-1">Previous Menstrual Dates</p>\
                ');
    
                $.each(data.menstruation_period_list, function (key, value) {
                    var menstruationDate = new Date(value.menstruation_date);
                    var monthNames = [
                        "January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"
                    ];
                    
                    var formattedDate = monthNames[menstruationDate.getMonth()] + ' ' +
                        menstruationDate.getDate() + ', ' +
                        menstruationDate.getFullYear();

                    var event = '<div class="fc-event previous_periods ml-2">' + formattedDate + '</div>';
                    time_line_container.append(event);
                });
            }
        });
    }
});

$("#menstrualPeriodForm").validate({
    rules: {
        menstruation_period: {
            required: true,
            date: true
        }
    },
    messages: {
        menstruation_period: {
            required: "Please select your menstruation period date",
            date: "Please enter a valid date",
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

$('#menstrualPeriodModal').on('hidden.bs.modal', function () {
    $('#menstrualPeriodForm').trigger('reset');
    $('#menstrualPeriodForm').validate().resetForm();

    $.each($('input[type=hidden]'), function () {
        if ($(this).attr('id') != 'id') $(this).val('');
    });
});

function getFullCalendar() {
    $.ajax({
        url: '../user/calendar/menstruation-periods',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.menstruation_period_list.length !== 0) {

                $('#calendar_card').removeClass('hidden');
                
                var event_arr = [];
                for (var i = 0; i < data.menstruation_period_list.length; i++) {
                    var event = {
                        id: data.menstruation_period_list[i].id,
                        title: i == 0 ? 'Last Menstruation Period' : 'Previous Menstruation Period',
                        description: 'Your recorded period: ' + data.menstruation_period_list[i].menstruation_date,
                        start: data.menstruation_period_list[i].menstruation_date
                    };
                    event_arr.push(event);
                }

                var events = {
                    backgroundColor: 'rgba(91,71,251,.2)',
                    borderColor: '#5b47fb',
                    events: event_arr
                }

                var estimated_period = {
                    backgroundColor: 'rgba(255,251,242, 1)',
                    borderColor: '#fbbc06',
                    events: [{
                        title: 'Estimated Next Period',
                        start: data.estimated_next_period
                    }]
                }

                calendar_period = $('#fullcalendar').fullCalendar({
                    header: {
                        left: 'prev,today,next',
                        center: 'title',
                        right: 'month,listMonth'
                    },
                    editable: false,
                    droppable: false, // this allows things to be dropped onto the calendar
                    dragRevertDuration: 0,
                    defaultView: 'month',
                    eventLimit: true, // allow "more" link when too many events
                    eventSources: [events, estimated_period]
                });
            }
            else {
                $('#calendar_card').addClass('hidden');

                $('#no_record').append('\
                    <div class="alert alert-warning" role="alert">\
                        <h4 h4 class= "alert-heading" > No record found!</h4>\
                        <p>It seems you don\'t have any menstrual records yet. To submit a record, go to "<strong>Menstrual Data</strong>" on the sidebar or you can just simply click "<strong>Add New Menstruation Period</strong>" button on the upper right side of the dashboard.</p>\
                    </div>\
                ');
            }

        }
    });
}

