<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendrier') }}
        </h2>
    </x-slot>

    <div class=" max-w-max mx-auto py-10 sm:px-6 lg:px-8 flex flex-row">

        <livewire:team-members-checkbox :$team />
        <livewire:calendar-component  :$team/>

    </div>

</div>

