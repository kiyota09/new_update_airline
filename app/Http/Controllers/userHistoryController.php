<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserHistory;
use Illuminate\Support\Facades\DB;
class userHistoryController extends Controller
{
    public function submitTransac(Request $request)
    {
        
            // Debug: show what was received (optional)
            // dd($request->all());

            $validated = $request->validate([
                'name' => 'required|string',
                'contact' => 'required|string',
                'flightNumber' => 'required|string',
                'origin' => 'required|string',
                'destination' => 'required|string',
                'date' => 'required|date',
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
            'paymentMethod' => $request->paymentMethod,
            'time' =>$request->time,
            'name' => $request->name,
            'contact' => $request->contact,
            'created_at' => now(),
        'updated_at' => now(),
        ]);
    
    }
}
