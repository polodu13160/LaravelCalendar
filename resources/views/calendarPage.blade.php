<div>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{--
                <x-welcome /> --}}
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="center-block">
                    <div class="max-w-7xl mx-auto">
                        <h2>Afficher Calendrier </h2>
                        <div class="checkbox-container">
                            <label class="checkbox-label">
                                <input type="checkbox" id="moi" name="affichage" value="moi" wire:model="choiceUser.User" wire:click='getEvents' 
                                    >
                                <span class="checkbox-custom"></span>
                                Moi
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" id="groupe" name="affichage" value="Groupe" wire:model="choiceUser.Group" wire:click='getEvents'>
                                <span class="checkbox-custom"></span>
                                Le groupe
                            </label>
                        </div>

                    
                         
                    </div>
                </div>

                    <div class="max-w-7xl mx-auto">
                        
                        {{-- <div id="calendar"></div> --}}
                        @livewire('calendar', ['icsUser' => $icsUser, 'icsGroup' => $icsGroup])
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/calendar.js')
    @script
    <script>
        let calendar;
        let iCalContents = {};
        let moiInput = document.querySelector('#moi');
        let groupInput = document.querySelector('#groupe');
    
        document.addEventListener("livewire:initialized", initializeCalendar);
        
    
    
    
    
        
    
        function createEventSources(urls, color) {
            return urls.map((url) => ({
                url: url,
                format: "ics",
                color: color
            }));
        }
    
    
       
    
        // document.addEventListener("livewire:initialized", function () {
            function initializeCalendar() {
            let calendarEl = document.querySelector("#calendar");
            
            let userEventSources =createEventSources (@this.icsUser, "blue")
            let groupEventSources = createEventSources(@this.icsGroup, "green")
    
           
    
            calendar = new window.Calendar(calendarEl, {
                plugins: [window.iCalendarPlugin],
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
                eventSources: userEventSources.concat(groupEventSources),
               eventMouseEnter: function(info) {
               fetchEventData(info.event.source.url).then(iCalText => {
                    let iCalContent = parseICalContent(iCalText);
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
                    info.el.onmouseout = function() {
                    if (document.body.contains(tooltip)) {
                    document.body.removeChild(tooltip);
                    }
                    };
           
                });
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
    
            
    
            window.addEventListener('scroll', function() {
                calendar.updateSize();
            });
            calendar.render();
        };
    
        function openModal(date) {
            console.log(date);
            Livewire.dispatch('openModal', { component: 'event-modal', arguments: { date: date } })
        }
    
       
    
        // setInterval(function () {
        //     calendar.refetchEvents();
        //     window.calen
        //     console.log("Refreshing events...");
        // }, 30 * 1000);
    
        
    
       async function fetchEventData(url) {
            const response = await fetch(url);
            const data = await response.text();
            return data;
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
    
    
        
    
    </script>
    @endscript
</div>
