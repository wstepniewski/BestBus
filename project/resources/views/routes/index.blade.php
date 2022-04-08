<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of routes') }}
        </h2>
    </x-slot>

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                @if($routes->isEmpty() && (!isset($connections) || !count($connections)))
                    <p class="p-6">No routes in database.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                From
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                To
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Travel Time
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Details</span>
                            </th>
                            @if(isset($connections))
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Thru</span>
                                </th>
                            @endif
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($routes as $route)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $route->cityFrom }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $route->cityTo }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $route->travelTime }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('routes.times.index', $route) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                </td>
                            </tr>
                        @endforeach
                        @if(isset($connections))
                            @foreach($connections as $connection)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ ucwords(strtolower($connection[0])) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ ucwords(strtolower($connection[count($connection)-2])) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $connection[count($connection)-1] }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form method="post" action="{{ route('routes.searchDirects') }}">

                                            @csrf

                                            <?php
                                            $connectionString = implode(' ', array_slice($connection, 0, -1));
                                            ?>
                                            <div>
                                                <x-input name="connection" type="hidden" value={{$connectionString}}/>
                                            </div>

                                            <div class="flex items-center justify-end mt-4">

                                                <x-button class="ml-4">
                                                    {{ __('Details') }}
                                                </x-button>
                                            </div>
                                        </form>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">
                                        @for($index = 1; $index<count($connection)-3; $index++)
                                                {{ ucwords($connection[$index]).', ' }}
                                            @endfor
                                            {{ ucwords($connection[count($connection)-3]) }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
