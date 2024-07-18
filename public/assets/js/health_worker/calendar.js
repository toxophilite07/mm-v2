$(document).ready(function (e) {
    $.ajax({
        url: '../health-worker/calendar-data',
        type: 'GET',
        success: function (data) {

            if (data.length !== 0) {

                var event_arr = [];
                for (var i = 0; i < data.length; i++) {
                    if (data[i].period_date !== null) {
                        var event = {
                            title: data[i].name,
                            start: data[i].period_date.menstruation_date
                        };
                        event_arr.push(event);
                    }
                }

                var events = {
                    backgroundColor: 'rgba(91,71,251,.2)',
                    borderColor: '#5b47fb',
                    events: event_arr
                }

                calendar_period = $('#fullcalendar').fullCalendar({
                    header: {
                        left: 'prev,today,next',
                        center: 'title',
                        right: 'month,listMonth'
                    },
                    editable: false,
                    droppable: false,
                    dragRevertDuration: 0,
                    defaultView: 'month',
                    eventLimit: true,
                    eventSources: [events]
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

        },
        error: function (data) {
            console.log(data);
        }
    });
});