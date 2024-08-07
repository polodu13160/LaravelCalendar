<div>

    <x-section-border />

    <!-- Add Team Member -->
    @canDoAction('Moderateur', $team->id)
    <div class="mt-10 sm:mt-0">
        <x-form-section submit="addTeamMember">
            <x-slot name="title">
                {{ __("Ajoutez des membres à l'équipe") }}
            </x-slot>

            <x-slot name="description">
                {{ __('Ajouter un nouveau collaborateur, par son email.') }}

            </x-slot>

            <x-slot name="form">
                @include('includes.form-search')
            </x-slot>

            <x-slot name="actions">
                <x-action-message class="me-3" on="teamMemberAdded">
                    {{ __('Added.') }}
                </x-action-message>

            </x-slot>
        </x-form-section>
    </div>

    @if ($team->teamInvitations->isNotEmpty())
        <x-section-border />

        <!-- Team Member Invitations -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("En attente d'invitation") }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Tous les collaborateurs qui ont été invités à rejoindre le groupe. ') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">

                        @foreach ($team->teamInvitations as $invitation)
                            @php($inviteUser = $invitation->load('user')->user)

                            <div class="grid grid-cols-10 gap-4 items-center">
                                <img class="w-8 h-8 rounded-full object-cover col-span-1"
                                    src="{{ $inviteUser->profile_photo_url }}" alt="{{ $inviteUser->name }}">
                                <div class="text-gray-600 col-span-3">{{ $inviteUser->name }}</div>
                                <div class="text-gray-600 text-right col-span-3">{{ $inviteUser->email }}</div>
                                <div class="text-gray-600 text-center col-span-2">{{ $invitation->role }}</div>

                                <div class="flex items-center justify-end col-span-1">

                                    <!-- Cancel Team Invitation -->
                                    <button class="cursor-pointer ms-6 text-sm text-red-500 focus:outline-none"
                                        wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                        {{ __('Cancel') }}
                                    </button>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif
    @endcanDoAction

    @if ($team->users->isNotEmpty())
        <x-section-border />

        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __("Les membres de l'équipe ") }}
                </x-slot>
                <x-slot name="description">
                    {{ __("Tous les membres de l'équipe") }}

                @isAdminOrModerateur($team)
                <br>
                {{ __("Vous pouvez changer le rôle de chaque membre." ) }}
                <br>
                <br>
                {{ "-Si modérateur, il peut voir les calendriers des autres utilisateurs." }}
                <br>
                {{ "-Si utilisateur, il ne peut voir que son propre calendrier." }}

                @endisAdminOrModerateur
                </x-slot>
                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            @if (!$user->hasrole('Admin'))
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="w-8 h-8 rounded-full object-cover"
                                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        <div class="ms-4  {{ $this->user->id === $user->id ? 'ms-4 font-bold' : '' }}">
                                            {{ $user->name }} {{ $user->email }}
                                            {{ $this->user->id === $user->id ? '( moi )' : '' }}
                                        </div>

                                    </div>
                                    @canDoAction('Moderateur', $team->id)
                                    <div class="flex items-center">
                                        @if ($team->user_id !== $user->id)
                                            @if ($user->id != $this->user->id)
                                                <select name="choix"
                                                    wire:change="setRole( $event.target.value,{{ $user->id }}, {{ $team->id }})">
                                                    @foreach ($roleTest as $role)
                                                        <option value="{{ $role->id }}"
                                                            {{ $user->teams->where('id', '=', $team->id)->first()->membership->role == $role->id ? 'selected' : '' }}>
                                                            {{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif

                                            <!-- Leave Team -->

                                            @if ($isAdmin || $team->user_id === $this->user->id)
                                                <!-- Remove Team Member -->
                                                <button class="cursor-pointer ms-6 text-sm text-green-500"
                                                    wire:click="changeLeader('{{ $user->id }}')">
                                                    {{ __('Définir comme Leader') }}
                                                </button>
                                                <button class="cursor-pointer ms-6 text-sm text-red-500"
                                                    wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                                    {{ __('Supprimer') }}
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                    @endcanDoAction
                                </div>
                            @endif
                        @endforeach
                    </div>
                </x-slot>
                <x-slot name="actions">
                    <x-action-message class="me-3" on="leaderChanged">
                        {{ __('Saved.') }}
                    </x-action-message>

                </x-slot>
            </x-action-section>
        </div>
    @endif
    <!-- Role Management Modal -->
    <x-dialog-modal wire:model.live="currentlyManagingRole">
        <x-slot name="title">
            {{ __('Manage Role') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                    <button type="button"
                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 {{ $index > 0 ? 'border-t border-gray-200 focus:border-none rounded-t-none' : '' }} {{ !$loop->last ? 'rounded-b-none' : '' }}"
                        wire:click="$set('currentRole', '{{ $role->key }}')">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div
                                    class="text-sm text-gray-600 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                    {{ $role->name }}
                                </div>

                                @if ($currentRole == $role->key)
                                    <svg class="ms-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-gray-600">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ms-3" wire:click="updateRole" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Leave Team Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
        <x-slot name="title">
            {{ __('Leave Team') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to leave this team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ __('Leave') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ __('Remove Team Member') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to remove this person from the team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ __('Remove') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>

