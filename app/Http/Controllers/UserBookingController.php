<?php

namespace App\Http\Controllers;

use App\Models\UserBookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class UserBookingController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'departureDate' => 'required|date',
            'returnDate' => 'nullable|date',
            'passengers' => 'required|string',
            'tripType' => 'required|string',
            'flightClasses' => 'required|string',
        ]);

        // Save booking
        $booking = new UserBookingModel();
        $booking->departure = $validated['departure'];
        $booking->destination = $validated['destination'];
        $booking->departureDate = $validated['departureDate'];
        $booking->returnDate = $validated['returnDate'] ?? null;
        $booking->passengers = $validated['passengers'];
        $booking->tripType = $validated['tripType'];
        $booking->flightClasses = $validated['flightClasses'];
        $booking->generated_by = Auth::id();
        $booking->save();

        return back()->with('success', 'Booking successfully created!');
    }

    public function searchRoutes(Request $request){

        $validated = $request->validate([
            'departure' => 'required|string',
            'destination' => 'required|string',
            'departureDate' => 'required|date_format:m/d/Y',
            'returnDate' => 'required|date_format:m/d/Y',
            'passengers' => 'required|string',
            'tripType' => 'required|string',
            'flightClasses' => 'required|string',
        ]);
        
        $start = Carbon::createFromFormat('m/d/Y', $request->departureDate)->startOfDay();
        $end = Carbon::createFromFormat('m/d/Y', $request->returnDate)->endOfDay();

        $routes = UserBookingModel::where('origin_route', $request->from)
        ->where('destination_route', $request->destination)
        ->whereBetween('date_column', [$start, $end])
        ->get();

    return response()->json($routes);
    }

}
