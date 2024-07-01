<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border-box">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-h-90% border-box">
            <div class="p-6 pt-0 lg:p-8 border-b border-box">
                <div class="max-w-7xl mx-auto border-box">
                    <div class="p-6 pt-0 lg:p-8 text-center">
                        <p class="text-lg leading-6 text-gray-500">Mon calendrier :
                            {{ $this->calendarUrlUserConnected }}</p>


                        @foreach ($this->calendarUrls as $key => $calendar)
                        @if ($key == 'team')
                        <p class="text-lg leading-6 text-gray-500"> {{ $team->name }} : {{ $calendar }} </p>
                        @else
                        <p class="text-lg leading-6 text-gray-500"> {{ $this->namesUsers[$key] }} : {{ $calendar }} </p>
                        @endif
                        @endforeach



                        <p><span class="text-sm italic">*à copier dans votre calendrier personnel</span></p>
                    </div>
                    <div class="border-box">
                        <div id="calendar-container" wire:ignore class="border-box">
                            <div id="calendar" class="border-box">
                            </div>
                        </div>
                    </div>

                    @vite(['resources/js/calendar.js'])
                    @script
                        <script>
                            let calendar;
                            let users;
                            let team;
                            let all;

                            document.addEventListener("livewire:initialized", initializeCalendar);




                            function initializeCalendar() {
                                let tooltip = document.createElement('div');
                                tooltip.style.position = 'absolute';
                                tooltip.style.backgroundColor = 'white';
                                tooltip.style.border = '1px solid black';
                                tooltip.style.padding = '10px';
                                tooltip.style.width = '400px';
                                tooltip.style.zIndex = '10000';
                                tooltip.style.display = 'none';
                                document.body.appendChild(tooltip);
                                let currentEvent = null;

                                let calendarEl = document.querySelector("#calendar");
                                calendar = new window.Calendar(calendarEl, {
                                plugins: [window.iCalendarPlugin],
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
                                eventMouseEnter: function(info) {
                                currentEvent = info.event;
                                fetchEventData(info.event.source.url).then(iCalText => {
                                let iCalContent = parseICalContent(iCalText);
                                tooltip.innerHTML = `
                                <strong>${info.event.title}</strong><br>
                                <strong>Date debut </strong> : ${info.event.start}<br>
                                <strong>Date fin </strong> : ${info.event.end}<br>
                                <strong>Description </strong> : ${info.event.extendedProps.description}<br>
                                <strong>Catégories </strong> : ${iCalContent.CATEGORIES}<br>
                                `;
                                let rect = info.el.getBoundingClientRect();
                                tooltip.style.left = (window.scrollX + rect.right) + 'px';
                                tooltip.style.top = (window.scrollY + rect.top) + 'px';
                                tooltip.style.display = 'block';
                                info.el.addEventListener('mouseleave', function() {
                                tooltip.style.display = 'none';
                                currentEvent = null;
                                });

                                });
                                },
                                eventResize: function(info) {},

                                select: function(info) {
                                console.log(info);
                                openModal();
                                },
                                eventClick: function(info) {
                                console.log(info.event);
                                openModal();
                                },
                                });

                                calendar.render();



                            }
                            Livewire.on("eventsHaveBeenFetched", () => {
                            calendar.removeAllEventSources();
                            console.log("Events have been fetched");
                            console.log(@this.allUrlIcsEvents);
                            for (let idOrTeam in @this.allUrlIcsEvents) {
                            console.log(idOrTeam);
                            let eventsIcs = @this.allUrlIcsEvents[idOrTeam];
                            let color= @this.colorByUserAndTeam[idOrTeam];
                            console.log(eventsIcs);
                            createEventSources(eventsIcs, color);



                            }

                            });
                            function openModal() {
                            Livewire.dispatch("openModal", {
                            component: "event-modal"
                            });
                            }



                            // setInterval(function() {
                            //     calendar.refetchEvents();
                            //     console.log("Refreshing events...");
                            // }, 30 * 1000);

                            // let fetchICal = window.calendarUrls.map((url) => ({
                            //     url: url,
                            //     format: "ics",
                            // }));

                            function fetchICalEvents() {

                                let iCalEvents = [];

                                fetchICal.forEach(element => {
                                    iCalEvents.push(element);
                                });
                                return iCalEvents;
                            }

                            // function fetchJSONEvents() {
                            //     return JSON.parse(@this.events).original;
                            // }


                            // function fetchAllSources() {

                            //     let allEvents = [];

                            //     allEvents.push(fetchICalEvents());
                            //     allEvents.push(fetchJSONEvents());
                            //     console.log(allEvents);
                            //     return allEvents;
                            // }

                            function createEventSources(urls, color) {


                            urls.map((url) => (
                            calendar.addEventSource(
                                {
                                    url: url,
                                    format: "ics",
                                    color: color,
                                }
                            )

                            ));

                            }

                            function parseICalContent(iCalContent) {

                            let lines = iCalContent.split('\n');
                            console.log(iCalContent);





                            let iCalObject = lines.reduce((acc, line) => {
                            let [key, ...value] = line.split(':');
                            acc[key] = value.join(':').trim();
                            return acc;
                            }, {});
                            return iCalObject;
                            }
                            async function fetchEventData(url) {
                            const response = await fetch(url);
                            const data = await response.text();
                            return data;
                            }







                        </script>
                    @endscript
                </div>
            </div>
        </div>
    </div>
</div>

