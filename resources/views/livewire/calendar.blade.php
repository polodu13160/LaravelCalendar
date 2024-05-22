<div>
    <div>{{ $this->calendarUrl }}</div>
    <div>
        <script>
            window.calendarUrls = @json($this->allUrlIcsEvents);
            window.events = @json($this->events);
        </script>
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
        @vite(['resources/js/calendar.js'])
    </div>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar/index.global.min.js"></script>
    
    <!--
    <script>
        let calendar;

        document.addEventListener("livewire:initialized", function () {
            let calendarEl = document.querySelector("#calendar");
            calendar = new FullCalendar.Calendar(calendarEl, {
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
                eventSources: [
                    window.calendarUrls.map((url) => ({
                        url: url,
                        format: "ics",
                    })),
                    JSON.parse(@this.events)
                ],

                select: function (info) {
                    console.log(fetchICal, JSON.parse(@this.events));
                    openModal();
                },
                eventClick: function (info) {
                    console.log(info.event);
                    openModal();
                },
            });

            calendar.render();

            function openModal() {
                Livewire.dispatch("openModal", { component: "event-modal" });
            }
        });

        setInterval(function () {
            calendar.refetchEvents();
            console.log("Refreshing events...");
        }, 30 * 100);

        let fetchICal = window.calendarUrls.map((url) => ({
            url: url,
            format: "ics",
        }));

    </script>
     -->
</div>
