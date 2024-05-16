import { Calendar } from 'fullcalendar';
import dayGridPlugin from '@fullcalendar/daygrid';
import iCalendarPlugin from '@fullcalendar/icalendar';
import ICAL from 'ical.js';
// console.log(window.calendarUrls);

document.addEventListener("livewire:initialized", function () {
    let calendarEl = document.querySelector("#calendar");
    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, iCalendarPlugin],
        eventSources: window.calendarUrls.map(url => ({ url: url, format: 'ics' }))
    });

    calendar.render();

    function openModal() {
        Livewire.dispatch("openModal", { component: "event-modal" });
    }
});