<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouteModel;
use Carbon\Carbon;


class RouteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'origin_route' => 'required|string|max:255',
            'destination_route' => 'required|string|max:255',
            'base_price' => 'required|integer|min:0',
            'duration' => 'required|string|max:255',
            'distance' => 'required|integer',
            'aircraft' => 'required|integer',
        ]);

        $routing = new RouteModel();
        $routing->origin_route = $validated['origin_route'];
        $routing->destination_route = $validated['destination_route'];
        $routing->base_price = $validated['base_price'];
        $routing->duration = $validated['duration'];
        $routing->distance = $validated['distance'];
        $routing->aircraft_id = $validated['aircraft'];
        $routing->save();

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $route = RouteModel::findOrFail($id);
        $route->update($request->only(['origin_route', 'destination_route', 'base_price', 'duration', 'distance']));
        return redirect()->back()->with('success', 'Route updated successfully!');
    }

    // Rename this method to 'destroy'
    public function destroy($id){
        $route = RouteModel::find($id);
        if (!$route) {
            return redirect()->back()->with('error', 'Route not found');
        }
        $route->delete();
        return redirect()->back()->with('success', 'Route deleted successfully');
    }


    
}
