import { Calendar } from 'fullcalendar';
import iCalendarPlugin from '@fullcalendar/icalendar';
import ICAL from 'ical.js';
// console.log(window.calendarUrls);

document.addEventListener("livewire:initialized", function () {
    let calendarEl = document.querySelector("#calendar");
    var calendar = new Calendar(calendarEl, {
        plugins: [iCalendarPlugin],
        editable: true,
        selectable: true,
        droppable: true,
        selectMirror: true,
        locale: "fr",
        weekNumberCalculation: "ISO",
        initialView: "timeGridWeek",
        headerToolbar: {
            left: "prev,next today",
            center: "title",
            right: "dayGridMonth,timeGridWeek,timeGridDay",
        },
        views: {
            dayGridMonth: {
                fixedWeekCount: false,
            },
        },
        eventSources: window.calendarUrls.map((url) => ({
            url: url,
            format: "ics",
        })),

        select: function (info) {
            console.log(info);
            openModal();
        },
    });

    calendar.render();

    function openModal() {
        Livewire.dispatch("openModal", { component: "event-modal" });
    }
});