<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>
    @if (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
    @endif
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{--
                <x-welcome /> --}}
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                    <div class="max-w-7xl mx-auto">
                        @livewire('calendar')
                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
