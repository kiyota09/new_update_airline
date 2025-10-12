<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RouteModel;

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
        ]);


        $routing = new RouteModel();
        $routing->origin_route = $validated['origin_route'];
        $routing->destination_route = $validated['destination_route'];
        $routing->base_price = $validated['base_price'];
        $routing->duration = $validated['duration'];
        $routing->distance = $validated['distance'];
        
        if ($routing->save()) {
    dd('Saved successfully!');
} else {
    dd('Failed to save!');
}

        return back();
    }
}
