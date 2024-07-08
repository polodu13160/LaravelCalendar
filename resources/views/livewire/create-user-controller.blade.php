<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-form-section submit="create()">
                <x-slot name="title">
                    {{ __('User Details') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Create a new User to collaborate with others on projects.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <x-label value="{{ __('User Owner') }}" />

                        <div class="col-span-6">
                            <div class="max-w-xl text-sm text-gray-600">
                                {{ __('Please provide the email address of the person you would like to add') }}
                            </div>

                        </div>

                        <!-- Member Email -->

                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="email" value="{{ __('Email') }}" />
                            <input list="emails" id="email" type="email" class="mt-1 block w-full"
                                wire:model="email" />
                            {{-- <datalist id="emails">
                                @foreach ($users as $user)
                                    <option value="{{ $user->email }}">{{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </datalist> --}}
                            <x-input-error for="email" class="mt-2" />
                        </div>

                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="name" value="{{ __('Nom') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" autofocus />
                        <x-input-error for="name" class="mt-2" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="username" value="{{ __('Username (doit etre unique)') }}" />
                        <x-input id="username" type="text" class="mt-1 block w-full" wire:model="username"  />
                        <x-input-error for="username" class="mt-2" />
                    </div>
          <div class="col-span-6 sm:col-span-4">
            <x-label for="chooseTeam" value="{{ __('Definir la team ? Peut être vide') }}" />
            <input id="chooseTeam" type="checkbox" class="mt-1 block" wire:click="toggleTeamSection">
          </div>

           @if($this->showTeamSection)
        <div class="col-span-6 sm:col-span-4">
            <x-label for="team" value="{{ __('Team') }}" />
            <select id="team" class="mt-1 block w-full" wire:model="team">
                <option value="0">-- Select Team --</option>
                @foreach($this->teams as $team)
                <option value="{{ $team->id }}" >{{ $team->name }}</option>
                @endforeach
            </select>
            <x-input-error for="team" class="mt-2" />
        </div>
        <div class="col-span-6 sm:col-span-4">
            <x-label for="role" value="{{ __('rôle') }}" />
            <select id="role" class="mt-1 block w-full" wire:model="role">
                <option value="0">-- Select Role --</option>
                @foreach($this->roles as $role)
                <option value="{{ $role->id }} >{{ $role->name }}</option>
                @endforeach
            </select>
            <x-input-error for="role" class="mt-2" />
        </div>
        @endif

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="password" value="{{ __('Password (mdp de base = password) ') }}" />
                        <x-input id="password" type="password" class="mt-1 block w-full" wire:model="password" />
                        <x-input-error for="password" class="mt-2" />
                    </div>





                </x-slot>

                <x-slot name="actions">
                    <x-button>
                        {{ __('Create') }}
                    </x-button>
                </x-slot>
            </x-form-section>

        </div>
    </div>
</div>

