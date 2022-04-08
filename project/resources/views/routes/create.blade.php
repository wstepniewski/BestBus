<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Creating a new connecton') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="post" action="{{ route('routes.store') }}">

                        @csrftest

                        <div>
                            <x-label for="cityFrom" :value="__('From:')" />
                            <x-input id="cityFrom" class="block mt-1 w-full" type="text" name="cityFrom" :value="old('cityFrom')" autofocus />
                        </div>

                        <div class="mt-4">
                            <x-label for="cityTo" :value="__('To:')" />
                            <x-input id="cityTo" class="block mt-1 w-full" type="text" name="cityTo" :value="old('cityTo')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="travelTimeHours" :value="__('Travel Time (Hours):')" />
                            <x-input id="travelTimeHours" class="block mt-1 w-full" type="text" name="travelTimeHours" :value="old('travelTimeHours')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="travelTimeMinutes" :value="__('Travel Time (Minutes):')" />
                            <x-input id="travelTimeMinutes" class="block mt-1 w-full" type="text" name="travelTimeMinutes" :value="old('travelTimeMinutes')" />
                        </div>

                        <div class="mt-4">
                            <x-label for="price" :value="__('Ticket Price:')" />
                            <x-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
