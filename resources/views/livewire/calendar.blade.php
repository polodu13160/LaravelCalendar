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
                                    <input type="checkbox" id="moi" name="affichage" value="moi"
                                        wire:model="choiceUser.User" wire:click="getEvents('submit')">
                                    <span class="checkbox-custom"></span>
                                    Moi
                                </label>
                                <label class="checkbox-label">
                                    <input type="checkbox" id="groupe" name="affichage" value="Groupe"
                                        wire:model="choiceUser.Group" wire:click="getEvents('submit')">
                                    <span class="checkbox-custom"></span>
                                    Le groupe
                                </label>
                                @isAdminOrModerator($this->teamId)
                                @foreach ($this->teamUsers as $item)
                                <label class="checkbox-label">
                                    <input type="checkbox" id="team.{{ $item->id }}" name="affichage"
                                        value="{{ $item->username }}" wire:model="choiceUser.Team.{{ $item->id }}"
                                        wire:click="getEvents('submit')">
                                    <span class="checkbox-custom"></span>
                                    {{ $item->name }}
                                </label>
                                @endforeach
                                @endisAdminOrModerator


                            </div>
                            <p>
                                <span
                                    style="display: inline-block; width: 20px; height: 20px; background-color: {{ $this->color['User'] }};"></span>
                                Moi : {{ $this->calendarUrl["User"] }}
                            </p>
                            <p>
                                <span
                                    style="display: inline-block; width: 20px; height: 20px; background-color: {{ $this->color['Group'] }};"></span>
                                Groupe : {{ $this->calendarUrl["Group"] }}
                            </p>
                            @foreach ($this->calendarUrl["Team"] as $key => $item)
                            <p>
                                <span
                                    style="display: inline-block; width: 20px; height: 20px; background-color: {{ $this->color['Team'][$key] }};"></span>
                                {{ $item[0] }} : {{ $item[1] }}
                            </p>
                            @endforeach



                        </div>
                    </div>

                    <div class="max-w-7xl mx-auto">


                        <div wire:ignore id="calendar"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>











</div>

{{-- Le reste de votre code Blade --}}

@vite('resources/js/calendar.js')


@script
<script>
    let iCalContents = {};
let calendar;

let checkUser ;
let userEventSources;

let checkGroup;
let groupEventSources;


let teamUsers ;
let teamEventIcs ;
let teamColor ;
let checkTeam;
let teamEventSources;







    
document.addEventListener("livewire:initialized", initializeCalendar);


    
Livewire.on('refresh', () => {
    
    let newCheckUser = document.getElementById('moi').checked;
    let newCheckGroup = document.getElementById('groupe').checked;
    let eventSources=calendar.getEventSources();
    let events = calendar.getEvents();

    if (newCheckUser==!checkUser){
        if (newCheckUser==true){
            userEventSources.forEach(source => {
            calendar.addEventSource(source);
            });
        }
        else {
            eventSources.forEach(source => {
                if (source.internalEventSource.ui.backgroundColor === @this.color['User']) {
                    console.log("remove");
                source.remove();
            }
            });
           
        }
        checkUser=newCheckUser;
    }
    if (newCheckGroup==!checkGroup){
        if (newCheckGroup==true){
        groupEventSources.forEach(source => {
        calendar.addEventSource(source);
        });
        }
        else {
        eventSources.forEach(source => {
            if (source.internalEventSource.ui.backgroundColor === @this.color['Group']) {
            source.remove();
        }
        });
        
        }
        checkGroup=newCheckGroup;
    }
    
    for (let element in checkTeam) {
        
        let newCheckTeam = document.getElementById('team.' + element).checked;
        // console.log(checkTeam[element],newCheckTeam);

        if (newCheckUser==!checkUser[element]){
            console.log("ha");
        if (newCheckUser==true){
        teamEventSources.forEach(source => {
        calendar.addEventSource(source);
        });
        }
        else {
        eventSources.forEach(source => {
        if (source.internalEventSource.ui.backgroundColor === @this.color['User']) {
        console.log("remove");
        source.remove();
        }
        });
        
        }
        checkUser=newCheckUser;
        }
    }
    
    





    });
      
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
        

        let calendarEl = document.getElementById("calendar");

        userEventSources =createEventSources(@this.icsUser, @this.color['User'])
        groupEventSources = createEventSources(@this.icsGroup, @this.color['Group'])
        checkUser= document.getElementById('moi').checked;
        checkGroup= document.getElementById('groupe').checked;

        teamEventSources = [];
        teamEventIcs = JSON.parse('@json($this->icsTeam)');
        teamUsers = JSON.parse('@json($this->userTeamIds)');
        checkTeam = {};
        

        for (let userTeamId of teamUsers) {
        let checkbox = document.getElementById('team.' + userTeamId);
        if (checkbox) {
        checkTeam[userTeamId] = checkbox.checked;
        }
        }
        

        for (let key in teamEventIcs) {
           teamEventSources = teamEventSources.concat(createEventSources(teamEventIcs[key], @this.color['Team'][key]));
        }
        
        
        
       

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
            eventSources: [
                ...userEventSources,
                ...groupEventSources,
                ...teamEventSources,
            ],
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
            select: function (info) {
                console.log(info);
                openModal(info.startStr);
            },
            eventClick: function (info) {
                console.log(info.event);
                openModal(info.startStr);
            },
        });

        // window.addEventListener('scroll', function() {
        //     calendar.updateSize();
        // });


        calendar.render();
    };

function openModal(date) {
    console.log(date);
    Livewire.dispatch('openModal', { component: 'event-modal', arguments: { date: date } })
}

   

   

    

   
async function fetchEventData(url) {
    const response = await fetch(url);
    const data = await response.text();
    return data;
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

function createEventSources(urls, color) {
    
   
    return urls.map((url) => (
      
    
    {
   
    url: url,
    format: "ics",
    color: color
    }));
    }


    

</script>
@endscript
</div>