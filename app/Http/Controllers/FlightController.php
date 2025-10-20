<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FlightController extends Controller
{
    // Render the Inertia page
    public function index()
    {
        $flights = Flight::orderBy('date')->get();
        return Inertia::render('adminUi/ScheduleManagement', [
            'flights' => $flights, // initial data for the calendar
        ]);
    }

    // JSON API for Axios
    public function apiIndex()
    {
        $flights = Flight::orderBy('date')->get();
        return response()->json($flights);
    }
    
    // Add new flight
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flightNo' => 'nullable|string|unique:flights,flightNo',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|string',
            'aircraft_id' => 'required|integer', 
        ]);

        if (empty($validated['flightNo'])) {
            $validated['flightNo'] = 'FL-' . rand(1000, 9999);
        }
        $flight = Flight::create($validated);
        return response()->json($flight, 201);
    }

    // Update existing flight
    public function update(Request $request, Flight $flight)
    {
        $validated = $request->validate([
            'origin' => 'required|string',
            'destination' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|string',
            'status' => 'required|string',
        ]);
        $flight->update($validated);
        return response()->json($flight);
    }

    // Delete flight
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->json(['message' => 'Flight deleted']);
    }

}
