<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class locationDestinationController extends Controller
{
    public function search_avial(Request $request)
    {
        $flights = DB::table('flights')
            ->where('origin', $request->departure)
            ->where('destination', $request->destination)
            ->where('date', $request->departureDate)
            ->get();


        return $flights;
    }
    public function selected_price(Request $request)
{
    $price = DB::table('routes_location')
        ->where('origin_route', $request->departure)
        ->where('destination_route', $request->destination)
        ->value('base_price'); // <- return only the 'price' field

    return response()->json([
        'price' => $price
    ]);
}
}
