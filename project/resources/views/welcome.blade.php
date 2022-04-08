<x-app-layout>

    <x-slot name="header">
        <div class="flex">

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <img src="BBlogo.png" style="height: 100px;">
                <p style="font-size: 70px; color: dodgerblue;"><b>Best Bus</b></p>
            </div>
        </div>
    </x-slot>


    <br><br>
    <form method="post" action="{{ route('routes.search') }}">

        @csrf

        <div>
            <x-label for="cityFrom" :value="__('From:')" />
            <x-input id="cityFrom" class="block mt-1 w-full" type="text" name="cityFrom" autofocus />
        </div>

        <div class="mt-4">
            <x-label for="cityTo" :value="__('To:')" />
            <x-input id="cityTo" class="block mt-1 w-full" type="text" name="cityTo" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-button class="ml-4">
                {{ __('Search Connections') }}
            </x-button>
        </div>
    </form>
    <div class="flex items-center justify-end mt-4">
        <form method="get" action="{{ route('routes.index')}}">
            <x-button class="ml-4">
                {{ __('Show All') }}
            </x-button>
        </form>
    </div>
    @if(Auth::user())
        @if(Auth::user()->isCarrier)
            <div class="flex items-center justify-end mt-4">
                <form method="get" action="{{ route('routes.create')}}">
                    <x-button class="ml-4">
                        {{ __('Add Connection') }}
                    </x-button>
                </form>
            </div>
        @endif
    @endif
</x-app-layout>
