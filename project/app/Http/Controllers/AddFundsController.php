<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AddFundsController extends Controller
{
    public function index()
    {
        return view('add-funds.index');//->with($routes);
    }

    public function confirm(Request $request )
    {

        $amount = $request->amount;
        if(empty($amount)){
            return view('add-funds.index')->withMessage("The Amount field is required");
        }
        if(!is_numeric($amount)){
            return view('add-funds.index')->withMessage("The Amount has to be numeric");
        }
        if($amount<0){
            return view('add-funds.index')->withMessage("The Amount has to be positive number");
        }

        Auth::user()->balance+=$amount;
        Auth::user()->save();
        if($request->routeToTicketsBuy == 1)
        {
            return redirect()->route('tickets.buy', $request);
        }
        return redirect()->route('dashboard');
    }

    public function show($amount)
    {
        return $amount;
    }
}
