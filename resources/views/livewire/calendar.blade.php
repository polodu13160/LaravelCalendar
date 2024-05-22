<div>
    <div>{{ $this->calendarUrl }}</div>
    <div>
        <script>
            window.calendarUrls = @json($this->allUrlIcsEvents);
        </script>
        <div id="calendar-container" wire:ignore>
            <div id="calendar"></div>
        </div>
        @vite(['resources/js/calendar.js'])
    </div>
</div>
