
$(document).ready(function () {
    
    $('#openCalendarBtn').on('click', function () {
        alert('HAi');
    $('#calendarModal').modal('show');

    // initialize only once
    setTimeout(function () {
        loadCalendar();
    }, 300);
});
let calendarInitialized = false;
let calendar;

function loadCalendar() {

    if (calendarInitialized) {
        calendar.render();
        return;
    }

    let calendarEl = document.getElementById('vehicleCalendar');

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: "auto",

        events: function (fetchInfo, successCallback) {

            $.ajax({
                url: '/LoadVehicleByUserSellection',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    action: 'vehicle_calendar'
                }),
                success: function (response) {

                    let events = [];

                    response.data.forEach(v => {

                        if (v.next_passing_date) {
                            events.push({
                                title: v.vehicle_number + ' (Passing)',
                                start: v.next_passing_date,
                                color: '#dc3545'
                            });
                        }

                        if (v.next_insurance_date) {
                            events.push({
                                title: v.vehicle_number + ' (Insurance)',
                                start: v.next_insurance_date,
                                color: '#0d6efd'
                            });
                        }

                        if (v.next_maintenance_date) {
                            events.push({
                                title: v.vehicle_number + ' (Maintenance)',
                                start: v.next_maintenance_date,
                                color: '#198754'
                            });
                        }

                    });

                    successCallback(events);
                }
            });
        }
    });

    calendar.render();
    calendarInitialized = true;
}
});