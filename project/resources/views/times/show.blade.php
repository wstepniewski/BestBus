<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule: ' . $route->cityFrom . ' -> ' . $route->cityTo) }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Detailed information.
                        </p>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Departure
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $time->departure }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Arrival
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ \App\appLogic\TimeLogic::getArrivalTime($time->departure, $route->travelTime) ?? 'No data' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Travel time
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $route->travelTime != '' ? $route->travelTime : 'No data' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Price
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $route->price . ' PLN' }}
                                </dd>
                            </div>

                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">

                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <form method="post" action="{{ route('tickets.buy') }}">
                                        @csrf

                                        <div>
                                            <x-input name="timeId" value="{{$time->id}}" hidden />
                                        </div>

                                        <x-button class="ml-4">
                                            {{ __('Buy') }}
                                        </x-button>

                                    </form>
                                </dd>
                            </div>

                        </dl>
                        @if(isset(Auth::user()->id) && $route->carrier_id == Auth::user()->id)
                            <div class="flex items-center justify-end mt-4">
                                <form method="get" action="{{ route('routes.times.edit', [$route, $time])}}">
                                    <x-button class="ml-4">
                                        {{ __('Edit Route') }}
                                    </x-button>
                                </form>
                            </div>
                            <form method="post" action="{{ route('routes.times.destroy', [$route, $time]) }}">

                                @csrf
                                @method("DELETE")

                                <x-button class="ml-4">
                                    {{ __('Delete') }}
                                </x-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
