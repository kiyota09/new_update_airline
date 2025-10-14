<?php

namespace App\Http\Controllers;

use App\Models\StaffModel;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function store(Request $request){
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'assignedFlight' => 'nullable|string|max:255',
            'status' => 'required|string',
        ]);

        $staff = new StaffModel();
        $staff->fullname = $validated['name'];
        $staff->role = $validated['role'];
        $staff->assignedFlight = $validated['assignedFlight'];
        $staff->status = $validated['status'];
        $staff->save();

        return back();

    }
}
