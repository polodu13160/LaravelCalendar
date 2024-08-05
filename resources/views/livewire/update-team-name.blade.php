<div>
    <x-form-section submit="updateTeamName">
        <x-slot name="title">
            {{ __('Team Name') }}
        </x-slot>

        <x-slot name="description">
            {{ __("Le nom de l'equipe, ne peut être modifié que par le responsable de l'équipe.") }}
        </x-slot>

        <x-slot name="form">
            <!-- Team Owner Information -->
            <div class="col-span-6">
                <x-label value="{{ __('Team Owner') }}" />

                <div class="flex items-center mt-2">
                    <img class="w-12 h-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}"
                        alt="{{ $team->owner->name }}">

                    <div class="ms-4 leading-tight">
                        <div class="text-gray-900">{{ $team->owner->name }}</div>
                        <div class="text-gray-700 text-sm">{{ $team->owner->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Team Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ __('Team Name') }}" />
                @if ($isModerator)
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name"
                        :disabled="!Gate::check('update', $team)" />

                    <x-input-error for="name" class="mt-2" />
                @else
                    <h3 class="mt-4 font-bold">{{$team->name}}</h3>
                @endif
            </div>
        </x-slot>

        @if (Gate::check('update', $team))
        @if ($isModerator)
            <x-slot name="actions">
                <x-action-message class="me-3" on="saved">
                    {{ __('Saved.') }}
                </x-action-message>

                <x-button>
                    {{ __('Save') }}
                </x-button>
            </x-slot>
            @endif
        @endif
    </x-form-section>

</div>

