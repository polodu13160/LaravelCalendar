<x-form-section submit="create()">
    <x-slot name="title">
        {{ __('Team Details') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Create a new team to collaborate with others on projects.') }}
    </x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-label value="{{ __('Team Owner') }}" />

            @include('includes.form-search-for-create')
            @if ($this->updateUserTeamOwner==!null)
            <div class="flex items-center mt-2">
                <img class="w-12 h-12 rounded-full object-cover" src="{{ $this->updateUserTeamOwner->profile_photo_url }}"
                    alt="{{ $this->updateUserTeamOwner->name }}">
            
                <div class="ms-4 leading-tight">
                    <div class="text-gray-900">{{ $this->updateUserTeamOwner->name }}</div>
                    <div class="text-gray-700 text-sm">{{ $this->updateUserTeamOwner->email }}</div>
                </div>
            </div>
            @endif
            
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Team Name') }}" />
            <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autofocus />
            <x-input-error for="name" class="mt-2" />
        </div>
       
    </x-slot>

    <x-slot name="actions">
        <x-button>
            {{ __('Create') }}
        </x-button>
    </x-slot>
</x-form-section>
