<div>

    <div class="mt-10 sm:mt-0">
        <x-calendar-team-action-section>
            <x-slot name="title">
                {{ __("Membre de l'équipe") }}
            </x-slot>

            <x-slot name="description">

            </x-slot>

            <!-- Team Member List -->
            <x-slot name="content">
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="ms-4">
                                Tous les événements
                            </div>
                        </div>
                        <div class="flex items">
                            {{-- <label for="">{{ $this->user->id }}</label> --}}
                            <input type="checkbox" wire:model="allTeamMembersSelected" wire:click="allCheckedBox()"
                                class="form-checkbox h-5 w-5 transition duration-100 ease-in-out"
                                style="color: black " />
                        </div>
                    </div>
                    @foreach ($this->teamMembers->sortBy('name') as $member)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img class="w-8 h-8 rounded-full object-cover" src="{{ $member->profile_photo_url }}"
                                    alt="{{ $member->name }}">
                                <div class="ms-4  {{ $this->user->id === $member->id ? 'ms-4 font-bold' : '' }}">
                                    {{ $member->name }} {{ $this->user->id === $member->id ? '( moi )' : '' }}
                                </div>

                            </div>
                            <div class="flex items ms-2">
                                {{-- <label for="">{{ $member->id }}</label> --}}
                                <input type="checkbox" wire:model="selectedUsers" value="{{ $member->id }}"
                                    wire:click="checkedBox()" class="form-checkbox h-5 w-5"
                                    style="color: {{ $member->color }}" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-slot>
        </x-calendar-team-action-section>
    </div>

</div>

