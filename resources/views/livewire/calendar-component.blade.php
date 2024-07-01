<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border-box">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-h-90% border-box">
            <div class="p-6 pt-0 lg:p-8 border-b border-box">
                <div class="max-w-7xl mx-auto border-box">
                    <div class="p-6 pt-0 lg:p-8 text-center">
                        <p class="text-lg leading-6 text-gray-500">Mon calendrier :
                            {{ $this->calendarUrlUserConnected }}</p>






                        <p class="text-lg leading-6 text-gray-500">Pour relier ce calendrier à Thunderbird :
                            {{ $this->calendarUrlUserConnected }}</p>
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


                            document.addEventListener("livewire:initialized", function() {
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

                                function openModal() {
                                    Livewire.dispatch("openModal", {
                                        component: "event-modal"
                                    });
                                }

                                Livewire.on("eventsHaveBeenFetched", () => {
                                    // calendar.removeAllEventSources();
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
                            });

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







                        </script>
                    @endscript
                </div>
            </div>
        </div>
    </div>
</div>

