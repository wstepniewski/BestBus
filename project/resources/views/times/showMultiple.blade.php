<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Connections: ' . $routeList[0]->cityFrom . '->' . $routeList[count($routeList)-1]->cityTo) }}
        </h2>

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach($routeList as $route)
                                <td colspan="2" class="relative px-6 py-3 font-semibold">
                                    {{ __($route->cityFrom . '->' . $route->cityTo) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($routeList as $route)
                                <?php $times = $route->times; ?>
                                @if($times->isEmpty())
                                    <th colspan="2" class="p-6">No timetables for this<br>route in database.</th>
                                @else
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Departure
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Details</span>
                                        </th>
                                @endif
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <?php
//                        $maxTimeIndex = 0;
//                        foreach($routeList as $route)
//                            {
//                                if(count($route->times) > $maxTimeIndex)
//                                {
//                                    $maxTimeIndex = count($route->times);
//                                }
//                            }
                    ?>
                        @for($timeIndex = 0; $timeIndex < $maxTimeIndex; $timeIndex++)
                            <tr>
                            @for($routeIndex = 0; $routeIndex < count($routeList); $routeIndex++)
                                @if(isset($routeList[$routeIndex]->times[$timeIndex]))
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $routeList[$routeIndex]->times[$timeIndex]->departure }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('routes.times.show', [$routeList[$routeIndex], $routeList[$routeIndex]->times[$timeIndex]]) }}" class="text-indigo-600 hover:text-indigo-900">Details</a>
                                    </td>
                                @else
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="text-sm text-gray-900"></div>
                                    </td>
                                @endif
                            @endfor
                            </tr>
                        @endfor

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
