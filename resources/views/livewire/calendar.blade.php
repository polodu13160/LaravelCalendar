<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendrier') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <livewire:team-members-checkbox :$team />
        <livewire:event-component />
        <livewire:calendar-component />

    </div>

</div>
