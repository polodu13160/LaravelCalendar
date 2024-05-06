<div>
    <div>
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar/index.global.min.js"></script>
    <script>
        document.addEventListener("livewire:initialized", function () {
            let calendarEl = document.querySelector("#calendar");
            let calendar = new FullCalendar.Calendar(calendarEl, {
                googleCalendarApiKey: "AIzaSyDU87dPFQKGPIkrU9TzcC5_-tv6_OH6J78",
                editable: true,
                selectable: true,
                droppable: true,
                selectMirror: true,
                aspectRatio: 1.5,
                locale: "fr",
                weekNumberCalculation: "ISO",
                initialView: "timeGridWeek",
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,list",
                },
                views: {
                    dayGridMonth: {
                        fixedWeekCount: false,
                        showNonCurrentDates: true,
                    },
                },
                eventSources: [JSON.parse(@this.events)],
                
                select: function (info) {
                    openModal();
                },
            });

            calendar.render();

            function openModal() {
                Livewire.dispatch("openModal", { component: "event-modal" });
            }
        });
    </script>
</div>
