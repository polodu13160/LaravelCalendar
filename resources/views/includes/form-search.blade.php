<div class="col-span-6">
    <div class="max-w-xl text-sm text-gray-600">
        {{ __('Please provide the email address of the person you would like to add to this team.') }}
    </div>
</div>

<!-- Member Email -->
<div class="col-span-6 sm:col-span-4">
    <x-label for="email" value="{{ __('Email') }}" />
    <x-input id="email" type="email" class="mt-1 block w-full" wire:model="addTeamMemberForm.email"
        wire:keydown.debounce.500ms="updateSearch" />
    <x-input-error for="addTeamMemberForm" class="mt-2" />
</div>

<div class="col-span-6 sm:col-span-6  ">
    <div class="inline-block min-w-full shadow rounded-lg overflow-auto" style="max-height: 300px;">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        User
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Mail
                    </th>
                    <th
                        class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        Role
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex items-center">
                                <div class="shrink-0 me-3">
                                    <img class="w-8 h-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                                        alt="{{ $user->name }}">
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        {{ $user->name }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $user->email }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="inline-flex mt-2 xs:mt-0">
                                <x-input-error for="role" class="mt-2" />
                                @foreach ($roleTest as $role)
                                    <button
                                        class="text-sm m-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded"
                                        wire:click="setFormValues('{{ $role->name }}','{{ $user->email }}')">
                                        {{ $role->name }}
                                    </button>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
