<?php

namespace App\Http\Controllers;

//use App\appLogic\TimeLogic;
use App\appLogic\SearchLogic;
use App\appLogic\TimeLogic;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class RouteController extends Controller
{
    public function index()
    {
        $routes = Route::all();
        return view('routes.index')->withRoutes($routes);
    }

    public function carrierRoutes()
    {
        $loggedUserId = Auth::user()->id;
        $routes = Route::all();
        $carrierRoutes=[];
        foreach($routes as $route)
        {
            if($route->carrier_id == $loggedUserId)
            {
                $carrierRoutes[] = $route;
            }
        }
        $carrierRoutes = collect($carrierRoutes);
        return view('routes.index')->withRoutes($carrierRoutes);
    }


    public function search(Request $request)
    {
        $this->validate($request, [
            'cityFrom' => 'required',
            'cityTo' => 'required'
        ]);

        $citiesColumns = SearchLogic::getNeededColumns(Route::all());

        $searcher = new SearchLogic($citiesColumns);
        $connections = $searcher->getIndirectConnections($request->cityFrom, $request->cityTo);

        $neededRoutes = SearchLogic::getDirectConnections($request->cityFrom, $request->cityTo);

        return view('routes.index')->withRoutes($neededRoutes)->with('connections', $connections);
    }


    public function searchDirects(Request $request)
    {
        $connection = explode(' ', $request->connection);

        $routeList = [];
        for($index = 0; $index < count($connection)-1; $index++)    // count($connection)-1 -> iterujemy bez czasu podróży
        {
            $routeList[] = SearchLogic::getDirectConnections($connection[$index], $connection[$index+1])[0];
        }

        $maxTimeIndex = 0;
        foreach($routeList as $route)
        {
            if(count($route->times) > $maxTimeIndex)
            {
                $maxTimeIndex = count($route->times);
            }
        }

        return view('times.showMultiple',['routeList'=> $routeList, 'maxTimeIndex'=>$maxTimeIndex]);
    }

    public function create()
    {
        if(Auth::user()->isCarrier)
        {
            return view('routes.create');
        }
        abort(404);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'cityFrom' => 'required',
            'cityTo' => 'required'
        ]);

        $route = new Route();
        $route->cityFrom = $request->cityFrom;
        $route->cityTo = $request->cityTo;
        $travelTime = TimeLogic::createTimeFromHoursAndMinutes($request->travelTimeHours, $request->travelTimeMinutes);
        $route->travelTime = $travelTime;
        $route->carrier_id = Auth::user()->id;
        $price = str_replace(',', '.', $request->price);
        $price = floatval($price);
        $route->price = $price;
        $route->save();

        return redirect()->route('routes.show', $route);
    }

    public function show(Route $route)
    {
        return view('times.index')->withRoute($route);
    }

    public function edit(Route $route)
    {
        if(Auth::user()->id == $route->carrier_id)
        {
            $hoursMinutesList = TimeLogic::getNumbers($route->travelTime);
            return view('routes.edit')->withRoute($route)->with('hoursMinutesList', $hoursMinutesList);
        }
        abort(404);
    }

    public function update(Request $request, Route $route): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'cityFrom' => 'required',
            'cityTo' => 'required'
        ]);

        $route->cityFrom = $request->cityFrom;
        $route->cityTo = $request->cityTo;
        $travelTime = TimeLogic::createTimeFromHoursAndMinutes($request->travelTimeHours, $request->travelTimeMinutes);
        $route->travelTime = $travelTime;
        $price = str_replace(',', '.', $request->price);
        $price = floatval($price);
        $route->price = $price;
        $route->save();

        return redirect()->route('routes.show', $route);
    }

    public function destroy(Route $route): \Illuminate\Http\RedirectResponse
    {
        if(Auth::user()->id == $route->carrier_id)
        {
            $route->delete();

            return redirect()->route('routes.index');
        }
        abort(404);
    }
}
