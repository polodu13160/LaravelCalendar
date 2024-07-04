<div class="p-6">
    <form wire:submit="save">
        <!-- title input -->
        <div>
            <x-label for="title" :value="__('title')" />
            <x-input wire:model="form.title" id="title" class="mt-1 block w-full" type="text" />
        </div>
        <!-- Description input -->
        <div class="mt-4">
            <x-label for="description" :value="__('Description')" />
            <textarea wire:model="form.description" id="description" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
        </div>
        <!-- Save button -->
        <div class="mt-4">
            <x-button>
                Save
            </x-button>
        </div>
    </form>
</div>