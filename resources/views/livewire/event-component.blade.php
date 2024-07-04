<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Events') }}
        </h2>
    </x-slot>
    <x-button wire:click="$dispatch('openModal', { component: 'event-modal' })" class="mb-4">
        New Product
    </x-button>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-hidden overflow-x-auto bg-white border-b border-gray-200">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full border divide-y divide-gray-200">
                            <!-- Table Header -->
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase">Name</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <span
                                            class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase">Description</span>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <button type="button"
                                            class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase bg-transparent border-none cursor-pointer">Date
                                            Debut</button>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50">
                                        <button type="button"
                                            class="text-xs font-medium leading-4 tracking-wider text-gray-500 uppercase bg-transparent border-none cursor-pointer">Date
                                            Fin</button>
                                    </th>
                                    <th class="px-6 py-3 text-left bg-gray-50"></th>
                                </tr>
                            </thead>
                            <!-- Table Body -->
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @forelse($events as $event)
                                    <tr>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                            {{ $event->title }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                            {{ $event->description }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900">

                                            {{ $event->start }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                            {{ $event->end }}
                                        </td>
                                        <td class="px-6 py-4 text-sm leading-5 text-gray-900">
                                            <x-button
                                                wire:click="$dispatch('openModal', { component: 'event-modal', arguments: { events: {{ $event }} }})">
                                                Edit
                                            </x-button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900">
                                            No products available.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

