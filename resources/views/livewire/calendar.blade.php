    <div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calendrier') }}
            </h2>
        </x-slot>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            <livewire:team-members-checkbox :$team />

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 border-box">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg max-h-90% border-box">
                        <div class="p-6 pt-0 lg:p-8 border-b border-box">
                            <div class="max-w-7xl mx-auto border-box">
                                <div class="p-6 pt-0 lg:p-8 text-center">
                                    <p class="text-lg leading-6 text-gray-500">Pour relier ce calendrier à Thunderbird :
                                        {{ $this->calendarUrl }}</p>
                                </div>
                                <div class="border-box">
                                    <script>
                                        window.calendarUrls = @json($this->allUrlIcsEvents);
                                        window.events = @json($this->events);
                                    </script>
                                    <div id="calendar-container" wire:ignore class="border-box">
                                        <div id="calendar" class="border-box">
                                            @vite(['resources/js/calendar.js'])
                                        </div>
                                    </div>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar/index.global.min.js"></script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

