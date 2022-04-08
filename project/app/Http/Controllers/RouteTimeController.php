<?php

namespace App\Http\Controllers;

use App\appLogic\TimeLogic;
use App\Models\Route;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteTimeController extends Controller
{
    public function index(Route $route)
    {
//        return view('times.index')->withRoute($route);
        $times=$route->times;
        return view('times.index',['route'=>$route, 'times'=>$times]);
    }

    public function create(Route $route)
    {
        if(Auth::user()->id == $route->carrier_id)
        {
            return view('times.create')->withRoute($route);
        }
        abort(404);
    }

    public function store(Request $request, Route $route)
    {
        $this->validate($request, [
            'departure' => 'required|regex:/(\d\d:\d\d)/'
        ]);
        $time = new Time();
        $time->route_id = $route->id;
        $time->departure = $request->departure;
        $time->save();

        return redirect()->route('routes.times.show', [$route, $time]);
    }

    public function show(Route $route, Time $time)
    {
        if($route->id != $time->route_id)
        {
            abort(404);
        }

        return view('times.show')->withRoute($route)->withTime($time); // ten time jest listą

    }

    public function edit(Route $route, Time $time)
    {
        if(Auth::user()->id == $route->carrier_id)
        {
            return view('times.edit')->withRoute($route)->withTime($time); // ten sam komentarz, co wyżej
        }
        abort(404);
    }

    public function update(Request $request, Route $route, Time $time)
    {
        $this->validate($request, [
            'departure' => 'required'
        ]);

        $time->departure = $request->departure;
        $time->save();

        return redirect()->route('routes.times.show', [$route, $time]);
    }

    public function destroy(Route $route, Time $time)
    {
        if(Auth::user()->id == $route->carrier_id)
        {
            $time->delete();

            return redirect()->route('routes.times.index', $route);
        }
        abort(404);
    }
}












