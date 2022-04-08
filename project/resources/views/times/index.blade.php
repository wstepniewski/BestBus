<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Schedule: ' . $route->cityFrom . ' -> ' . $route->cityTo) }}
        </h2>


    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(isset(Auth::user()->id) && $route->carrier_id == Auth::user()->id)
                    <div class="flex items-center justify-end mt-4">
                        <form method="get" action="{{ route('routes.times.create', $route)}}">
                            <x-button class="ml-4">
                                {{ __('Add Route') }}
                            </x-button>
                        </form>
                    </div>
                @endif
                @if($route->times->isEmpty())
                    <p class="p-6">No timetables for this route in database.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departure
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="sr-only">Details</span>
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Buy ticket</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($route->times as $time)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $time->departure }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('routes.times.show', [$route, $time]) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="post" action="{{ route('tickets.buy') }}">

                                        @csrf

                                        <div>
                                            <x-input name="timeId" value="{{$time->id}}" hidden />
                                        </div>

                                        <div class="flex items-center justify-end mt-4">

                                            <x-button class="ml-4">
                                                {{ __('Buy') }}
                                            </x-button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @endif
                    @if(isset(Auth::user()->id) && $route->carrier_id == Auth::user()->id)
                        <div class="flex items-center justify-end mt-4">
                            <form method="get" action="{{ route('routes.edit', $route)}}">
                                <x-button class="ml-4">
                                    {{ __('Edit connection') }}
                                </x-button>
                            </form>
                        </div>
                        <form method="post" action="{{ route('routes.destroy', $route) }}">

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
</x-app-layout>
