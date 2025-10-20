<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\AircraftModel;

class AdminController extends Controller
{
    public function index(Request $request)
    {

        $validated = $request->validate([
            'idnum'    => 'required|integer|max:100',
            'model'     => 'required|string|max:255',
            'registration'   => 'required|string|max:255',
            
            'location'       => 'required|string',
        ]);


        $aircraft = new AircraftModel();
        $aircraft->aircraft_id = $validated['idnum'];
        $aircraft->model = $validated['model'];
        $aircraft->registration = $validated['registration'];
        $aircraft->location = $validated['location'];
        $aircraft->save();

        return back()->with('success', 'Adding Aircraft Successfully!');
    }

    public function show()
    {
        $aircraftss = AircraftModel::all();

        return Inertia::render('adminUi/Aircraft', ['aircraftss' => $aircraftss]);
    }

    public function destroy($id)
{
    $aircraft = AircraftModel::find($id);

    if (!$aircraft) {
        return response()->json(['message' => 'Aircraft not found'], 404);
    }

    $aircraft->delete();

}

}
