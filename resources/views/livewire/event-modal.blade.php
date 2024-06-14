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
            <x-input-error for="form.title" class="mt-2" />
        </div>
        <!-- Description input -->
        <div class="mt-4">
            <x-label for="description" :value="__('Description')" />
            <textarea
                wire:model="form.description"
                id="description"
                class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            ></textarea>
           <x-input-error for="form.description" class="mt-2" />
        </div>
        <!-- is_all_day input -->
        <div>
            <x-label for="is_all_day" :value="__('Is all day ')" />
            <x-checkbox wire:model="form.is_all_day" id="is_all_day" />
        </div>
        <!-- visibility checkbox -->
        <div>
            <x-label for="visibility" :value="__('Private')" />
            <x-checkbox wire:model="form.visibility" id="visibility" />
            <x-input-error for="form.visibility" class="mt-2" />
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
           <x-input-error for="form.start" class="mt-2" />
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
            <x-input-error for="form.end" class="mt-2" />
        </div>
        <div>
            <x-label for="backgroundColor" :value="__('Background Color')" />
            <x-input wire:model="form.backgroundColor" id="backgroundColor" class="mt-1 block w-16" type="color" />
            <x-input-error for="form.backgroundColor" class="mt-2" />
        </div>
        
        <div>
            <x-label for="borderColor" :value="__('Border Color')" />
            <x-input wire:model="form.borderColor" id="borderColor" class="mt-1 block w-16" type="color" />
            <x-input-error for="form.borderColor" class="mt-2" />
        </div>
        <div>
            <x-label for="categorieIcal">{{ __('Categorie') }}</x-label>
            <select wire:model="form.categorieIcal" id="categorieIcal" class="mt-1 block w-45">
                @foreach ($allCategoriesIcal as $value)
                <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            <x-input-error for="categorieIcal" class="mt-2" />
        </div>
        

        <!-- Save button -->
        <div class="mt-4">
            <x-button> Save </x-button>
        </div>
    </form>
</div>
