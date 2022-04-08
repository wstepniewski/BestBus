<?php

namespace App\Http\Controllers;

use App\appLogic\SearchLogic;
use App\appLogic\TimeLogic;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Ticket;
use App\Models\Time;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
//use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\Facade as PDF;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function generatePDF(Ticket $ticket)
    {

        $data=['ticket'=>$ticket];
        //$pdf = PDF::loadView('tickets.ticket', $data);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadView('tickets.ticket', $data);

        $ticketName = 'Ticket'.$ticket->id;

        return $pdf->download($ticketName);
    }

    public function buy(Request $request)
    {
        //return $request;

        $neededTime = SearchLogic::getTimeById($request->timeId);
        if(!isset(Auth::user()->id))
        {
            return view("tickets.create")->withTime($neededTime);
        }

        if(!isset(Auth::user()->id) || Auth::user()->balance < floatval($neededTime->route->price))
        {
            $missingFunds = $neededTime->route->price;
            $missingFunds -= isset(Auth::user()->id) ? Auth::user()->balance : 0;
            return view("add-funds.index")->with('insufficientFunds', 'Insufficient funds - '.number_format($missingFunds,2).' zł')->with('timeId', $request->timeId)->with('routeToTicketsBuy', 1);
        }

        return view("tickets.create")->withTime($neededTime);
    }

    public function store(Request $request)
    {
        //return $request->date;
        $this->validate( $request, [
            'date' => 'required',
            'departure'=>'required',
            'price' => 'required',
            'cityFrom' => 'required',
            'cityTo' => 'required',
            'carrier_id' => 'required'
        ]);


        $ticket = new Ticket();
        $ticket->day = $request->date;
        $ticket->departure = $request->departure;
        $ticket->arrival = TimeLogic::getArrivalTime($request->departure, $request->travelTime);
        $ticket->price = $request->price;
        $ticket->cityFrom = $request->cityFrom;
        $ticket->cityTo = $request->cityTo;
        $ticket->traveler = Auth::user()->name ?? '';
        $ticket->user_id = Auth::user()->id ?? null;
        $ticket->carrier_id = $request->carrier_id;

        $ticket->save();
        if(isset(Auth::user()->id))
        {
            Auth::user()->balance -= floatval($request->price);
            Auth::user()->save();
        }

        return redirect()->route('tickets.show', $ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.show')->withTicket($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
