<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-1 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg">
            {{ $content }}
        </div>
        @if (isset($actions))
        <div
        class="flex items-center justify-end px-4 py-3 bg-none text-end sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
            {{ $actions }}
        </div>
        @endif
    </div>
</div>
