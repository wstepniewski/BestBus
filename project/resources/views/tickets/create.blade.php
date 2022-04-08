<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buying a ticket') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="post" action="{{ route('tickets.store') }}">

                        @csrf

                        <div>
                            <x-label for="date" :value="__('Choose Date')" />
                            <x-input id="date" class="block mt-1 w-full" type="date" name="date" placeholder="yyyy-mm-dd" :value="old('date')" autofocus />
                        </div>

                        <x-input name="departure" value="{{$time->departure ?? old('departure')}}" hidden />
                        <x-input name="price" value="{{$time->route->price ?? old('price')}}" hidden />
                        <x-input name="cityFrom" value="{{$time->route->cityFrom ?? old('cityFrom')}}" hidden />
                        <x-input name="cityTo" value="{{$time->route->cityTo ?? old('cityTo')}}" hidden />
                        <x-input name="travelTime" value="{{$time->route->travelTime ?? old('travelTime')}}" hidden />
                        <x-input name="carrier_id" value="{{$time->route->carrier_id ?? old('carrier_id')}}" hidden />

                        <br>Departure: {{$time->departure?? old('departure')}}
                        <br>Price: {{number_format($time->route->price ?? old('price'),2)}} PLN

                        <div class="flex items-center justify-end mt-4">

                            <x-button class="ml-4">
                                <?php $buttonMessage = isset(Auth::user()->id) ? 'Buy' : 'Pay'; ?>
                                {{ __($buttonMessage) }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
