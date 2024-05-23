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
</div>
