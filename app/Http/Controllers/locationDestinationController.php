<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\AircraftModel;

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
    public function flight_aircraft(Request $request)
    {
        dd($request);
        $aircraft_id = DB::table('aircraft')
            ->where('id', $request->aircraft_id)
            ->get();

        return response()->json([
            'aircraft_id' => $aircraft_id
        ]);
    }


    public function getByFlightid($flight_id)
    {
        $staff = AircraftModel::where('assignedFlight', $flight_id)->get();
        return response()->json($staff);
    }

    public function full_flight_details(Request $request)
    {
        $flights = DB::table('flights as f')
            ->join('aircraft as a', 'a.id', '=', 'f.aircraft_id')
            ->where('f.origin', $request->departure)
            ->where('f.destination', $request->destination)
            ->where('f.date', $request->departureDate)
            
            ->select(
                'f.*',
                'a.model',
                'a.registration',
                'a.location',
                'a.status as aircraft_status',
            )
            ->get();
        return response()->json($flights);
    }
}
