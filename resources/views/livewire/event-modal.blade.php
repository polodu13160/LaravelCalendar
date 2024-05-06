<div class="p-6">
    <form wire:submit="save">
        <!-- title input -->
        <div>
            <x-label for="title" :value="__('Title')" />
            <x-input
                wire:model="form.title"
                id="title"
                class="mt-1 block w-full"
                type="text"
            />
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- Description input -->
        <div class="mt-4">
            <x-label for="description" :value="__('Description')" />
            <textarea
                wire:model="form.description"
                id="description"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            ></textarea>
            @error('description')
            <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- is_all_day input -->
        <div>
            <x-label for="is_all_day" :value="__('Is all day ')" />
            <x-checkbox wire:model="form.is_all_day" id="is_all_day" />
        </div>
        <!-- visibility input -->
        <div>
            <x-label for="visibility" :value="__('Private')" />
            <x-checkbox wire:model="form.visibility" id="visibility" />
        </div>
        <!-- start input -->
        <div>
            <x-label for="start" :value="__('Start')" />
            <x-input
                wire:model="form.start"
                id="start"
                class="mt-1 block w-full"
                type="datetime-local"
            />
            @error('start') <span class="error">{{ $message }}</span> @enderror
        </div>
        <!-- end input -->
        <div>
            <x-label for="end" :value="__('End')" />
            <x-input
                wire:model="form.end"
                id="end"
                class="mt-1 block w-full"
                type="datetime-local"
            />
            @error('end') <span class="error">{{ $message }}</span> @enderror
        </div>

        <!-- Save button -->
        <div class="mt-4">
            <x-button> Save </x-button>
        </div>
    </form>
</div>
