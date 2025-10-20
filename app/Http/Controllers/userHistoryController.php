<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UserHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class userHistoryController extends Controller
{
    public function submitTransac(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'flightNumber' => 'required|string',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'class' => 'required|string',
            'date' => 'required|date',
            'passenger' => 'required|integer',
            'totalPrice' => 'required|numeric',
            'paymentMethod' => 'required|string',
            'time' => 'required|string',
        ]);

        DB::table('history')->insert([
            'flightNo' => $request->flightNumber,
            'origin' => $request->origin,
            'destination' => $request->destination,
            'date' => $request->date,
            'price' => $request->totalPrice,
            'class' => $request->class,
            'paymentMethod' => $request->paymentMethod,
            'time' => $request->time,
            'name' => $request->name,
            'passenger' => $request->passenger,
            'contact' => $request->contact,
            'created_at' => now(),
            'updated_at' => now(),
            'user_id' => Auth::id(),
            'payment_ref' => 'Ref: '.  Str::upper(Str::random(8)),
            'ticket' => 'SkyWings-' . date('Ymd-') . Str::upper(Str::random(8)),
            'booking_id' => 'Book-' . date('Ymd-') . Str::upper(Str::random(8)),
        ]);
    }

    // public function show_passenger(Request $request)
    // {
    //     $user_history = DB::table('history as h')
    //         ->where('h.user_id', Auth::id())
    //         ->orderBy('h.created_at', 'desc')
    //         ->get();

    //     return response()->json($user_history);
    // }
}
