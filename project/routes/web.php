<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    $total_value=0;
    $tickets=auth()->user()->tickets;
    $sold_tickets=[];
    if($user=auth()->user()){
        if($user->isCarrier) {
            $sold_tickets = auth()->user()->sold_tickets;
            foreach ($sold_tickets as $ticket) {
                $total_value += $ticket->price;
            }
        }
    }
    return view('dashboard', ['sold_tickets'=>$sold_tickets,'tickets'=>$tickets, 'total_value'=>$total_value]);
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::resource('/routes', App\Http\Controllers\RouteController::class);
Route::resource('/routes.times', App\Http\Controllers\RouteTimeController::class);
Route::resource('/add-funds', App\Http\Controllers\AddFundsController::class);
Route::resource('/tickets', App\Http\Controllers\TicketController::class);

Route::post('routes/search', ['as' => 'routes.search', 'uses' => 'App\Http\Controllers\RouteController@search']);
Route::post('routes/searchDirects', ['as' => 'routes.searchDirects', 'uses' => 'App\Http\Controllers\RouteController@searchDirects']);
Route::post('routes/carrierRoutes', ['as' => 'routes.carrierRoutes', 'uses' => 'App\Http\Controllers\RouteController@carrierRoutes']);

Route::post('add-funds/index', ['as' => 'add-funds.index', 'uses' => 'App\Http\Controllers\AddFundsController@index']);
Route::post('add-funds/confirm', ['as' => 'add-funds.confirm', 'uses' => 'App\Http\Controllers\AddFundsController@confirm']);

Route::post('ticket/buy', ['as' => 'tickets.buy', 'uses' => 'App\Http\Controllers\TicketController@buy']);
Route::get('ticket/buy', ['as' => 'tickets.buy', 'uses' => 'App\Http\Controllers\TicketController@buy']);
Route::get('ticket/generatePDF{ticket}', ['as' => 'tickets.generatePDF', 'uses' => 'App\Http\Controllers\TicketController@generatePDF']);

