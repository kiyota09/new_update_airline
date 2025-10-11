<?php

namespace App\Http\Controllers;

use App\Models\UserBookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
