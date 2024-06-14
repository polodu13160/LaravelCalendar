<div>

    @if ($team->users->isNotEmpty())

        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-calendar-team-action-section>
                <x-slot name="title">
                    {{ __('Team Members') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('All of the people that are part of this team.') }}
                </x-slot>

                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="ms-4">
                                            Tous
                                        </div>

                                    </div>
                                    <div class="flex items">
                                        {{-- <label for="">{{ $user->id }}</label> --}}
                                        <input type="checkbox" wire:model="selectAll"
                                            wire:click="allCheckedBox()" 
                                            class="form-checkbox h-5 w-5 text-indigo-600 transition duration-100 ease-in-out" />
                                    </div>
                                </div>
                        @foreach ($this->userTeam->sortBy('name') as $user)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <img class="w-8 h-8 rounded-full object-cover"
                                            src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                                        <div class="ms-4  {{ $this->user->id === $user->id ? 'ms-4 font-bold' : '' }}">
                                            {{ $user->name }} {{ $this->user->id === $user->id ? '( moi )' : '' }}
                                        </div>

                                    </div>
                                    <div class="flex items">
                                        {{-- <label for="">{{ $user->id }}</label> --}}
                                        <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}"
                                            wire:click="checkedBox()"
                                            class="form-checkbox h-5 w-5 text-indigo-600 transition duration-100 ease-in-out" />
                                    </div>
                                </div>
                          
                        @endforeach
                    </div>
                </x-slot>
            </x-calendar-team-action-section>
        </div>
    @endif
    {{-- Selected Users : {{ implode(', ', $selectedUsers) }} --}}
</div>

