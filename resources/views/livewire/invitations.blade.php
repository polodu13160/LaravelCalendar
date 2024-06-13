<div>
    {{-- {{ dd($this->invitation) }} --}}
    @foreach ($this->invitation as $invite)
        <div class="card">
            <div class="card-header">
                <h3 class="mb-4 text-3xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl dark:text-black">{{ $invite->team->name }}</h3>
            </div>
            <div class="card-body">
                <div class="card-body">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p>{{ $invite->userCreateInvite->name }} vous a invité en tant que {{ $invite->role }} </p>
                        <div>
                            <button wire:click="acceptInvitation({{ $invite }},1)"
                                class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5" />
                                </svg>
                                Accepter</button>
                            <button wire:click="acceptInvitation({{ $invite }},0)"
                                class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                                </svg>
                                Refuser</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endforeach
</div>

