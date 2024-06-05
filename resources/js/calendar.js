import { Calendar } from "fullcalendar";
import iCalendarPlugin from "@fullcalendar/icalendar";
import ICAL from "ical.js";

let calendar;
let iCalContents = {}; 




let fetchICal = [];
if (window.calendarUrls.User.length > 0) {
    fetchICal.push(...window.calendarUrls.User.map((url) => ({
        url: url,
        format: "ics",
        color: "green"
    })));
}
if (window.calendarUrls.Group.length > 0) {
    fetchICal.push(...window.calendarUrls.Group.map((url) => ({
        url: url,
        format: "ics",
        color: "red"
    })));
}
if (window.calendarUrls.Name.length > 0) {
    fetchICal.push(...window.calendarUrls.Name.map((url) => ({
        url: url,
        format: "ics",
        color: "blue"
    })));
}



// console.log(fetchICal);

function fetchICalEvents() {
    let fetchPromises = fetchICal.map(element => {
        return fetch(element.url)
            .then(response => response.text())
            .then(data => {
                iCalContents[element.url] = data; 
                return element;
            });
    });

    return Promise.all(fetchPromises);
}

document.addEventListener("livewire:initialized", function () {
    let calendarEl = document.querySelector("#calendar");

    calendar = new Calendar(calendarEl, {
        plugins: [iCalendarPlugin],
        editable: true,
        slotMinTime: "06:00:00",
        slotMaxTime: "20:00:00",
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
        eventMouseEnter: function(info) {
            
            let iCalContent = parseICalContent(iCalContents[info.event.source.url]);
            
            let tooltip = document.createElement('div');
            tooltip.style.position = 'absolute';
            tooltip.style.backgroundColor = 'white';
            tooltip.style.border = '1px solid black';
            tooltip.style.padding = '10px';
            tooltip.style.width = '400px';
            tooltip.style.zIndex = '10000'; 

            tooltip.innerHTML = `
                <strong>${info.event.title}</strong><br>
                <strong>Date debut </strong> : ${info.event.start}<br>
                <strong>Date fin </strong> : ${info.event.end}<br>
                <strong>Description </strong> : ${info.event.extendedProps.description}<br>
                <strong>Catégories </strong> : ${iCalContent.CATEGORIES}<br> 
            `;

            
            document.body.appendChild(tooltip);

            
            let rect = info.el.getBoundingClientRect();
            tooltip.style.left = (window.scrollX + rect.right) + 'px';
            tooltip.style.top = (window.scrollY + rect.top) + 'px';

            
            info.el.onmouseleave = function() {
                document.body.removeChild(tooltip);
            };
        },
        select: function (info) {
            console.log(info);
            openModal(info.startStr);
        },
        eventClick: function (info) {
            console.log(info.event);
            openModal(info.startStr);
        },
    });

    fetchICalEvents().then(iCalEvents => {
        calendar.setOption('eventSources', iCalEvents);
        calendar.render();
    });

    window.addEventListener('scroll', function() {
        calendar.updateSize();
    });
});

function openModal(date) {
    console.log(date);
    Livewire.dispatch('openModal', { component: 'event-modal', arguments: { date: date } })
}

function parseICalContent(iCalContent) {
    let lines = iCalContent.split('\n');
    let iCalObject = lines.reduce((acc, line) => {
        let [key, ...value] = line.split(':');
        acc[key] = value.join(':').trim();
        return acc;
    }, {});

    return iCalObject;
}

setInterval(function () {
    calendar.refetchEvents();
    console.log("Refreshing events...");
}, 30 * 1000);