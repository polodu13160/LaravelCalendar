// import { Calendar } from "fullcalendar";
// import iCalendarPlugin from "@fullcalendar/icalendar";
// import ICAL from "ical.js";

// let calendar;

// document.addEventListener("livewire:initialized", function () {
//     let calendarEl = document.querySelector("#calendar");
//     calendar = new Calendar(calendarEl, {
//         plugins: [iCalendarPlugin],
//         editable: true,
//         selectable: true,
//         droppable: true,
//         selectMirror: true,
//         locale: "fr",
//         weekNumberCalculation: "ISO",
//         initialView: "timeGridWeek",
//         headerToolbar: {
//             left: "prev,next today",
//             center: "title",
//             right: "dayGridMonth,timeGridWeek,timeGridDay",
//         },
//         views: {
//             dayGridMonth: {
//                 fixedWeekCount: false,
//             },
//         },
//         // eventSources: fetchICalEvents(),
//         eventSources: "refetch-events",

//         select: function (info) {
//             console.log(info);
//             openModal();
//         },
//         eventClick: function (info) {
//             console.log(info.event);
//             openModal();
//         },
//     });

//     calendar.render();

//     function openModal() {
//         Livewire.dispatch("openModal", { component: "event-modal" });
//     }
// });

// setInterval(function () {
//     calendar.refetchEvents();
//     console.log("Refreshing events...");
// }, 30 * 1000);

// let fetchICal = window.calendarUrls.map((url) => ({
//     url: url,
//     format: "ics",
// }));

// function fetchICalEvents() {

//     let iCalEvents = [];
    
//     fetchICal.forEach(element => {
//         iCalEvents.push(element);
//     });
//     return iCalEvents;
// }

// function fetchJSONEvents() {
//     return JSON.parse(window.events);
// }


// function fetchAllSources() {

//     let allEvents = [];
    
//     allEvents.push(fetchICalEvents());
//     allEvents.push(fetchJSONEvents());
//     console.log(allEvents);
//     return allEvents;
// }
