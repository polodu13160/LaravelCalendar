<div class="p-6">
    <form wire:submit="update" >
        <!-- title input -->
        <div>
            <x-label for="title" :value="__('Titre')" />
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
            <x-label for="is_all_day" :value="__('Toute la journée')" />
            <x-checkbox wire:model="form.is_all_day" id="is_all_day" />
        </div>
        <!-- visibility checkbox -->
        <div>
            <x-label for="visibility" :value="__('Visibilité')" />
            <select wire:model="form.visibility" id="visibility" name="visibility" class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="public">Public</option>
                <option value="private">Privé</option>
                <option value="confidential">Confidentiel</option>
            </select>
            <x-input-error for="form.visibility" class="mt-2" />
        </div>
        <!-- start input -->
        <div>
            <x-label for="start" :value="__('Début')" />
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
            <x-label for="end" :value="__('Fin')" />
            <x-input
                wire:model="form.end"
                id="end"
                class="mt-1 block w-full"
                type="datetime-local"
            />
            <x-input-error for="form.end" class="mt-2" />
        </div>
        <!-- Save button -->
        <div class="mt-4">
            <x-button> Save </x-button>
        </div>
    </form>
</div>
