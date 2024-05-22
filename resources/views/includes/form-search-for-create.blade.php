<div class="col-span-6">
    <div class="max-w-xl text-sm text-gray-600">
        {{ __('Please provide the email address of the person you would like to add to this team.') }}
    </div>

</div>


<!-- Member Email -->


<div class="col-span-6 sm:col-span-4">
    <x-label for="email" value="{{ __('Email') }}" />
    <input list="emails" id="email" type="email" class="mt-1 block w-full" wire:model="email" wire:keydown.debounce.500ms="updateSearchAndUser($event.target.value)" />
    <datalist id="emails">
        @foreach($users as $user)
        <option value="{{ $user->email}}">{{ $user->name }} ({{ $user->email }})</option>
        @endforeach
    </datalist>
    <x-input-error for="email" class="mt-2" />
</div>