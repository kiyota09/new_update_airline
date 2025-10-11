<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\AdditionalDataModel;

class AdditionUserData extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/AdditionUserData');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstname'     => 'required|string|max:255',
            'lastname'      => 'required|string|max:255',
            'middlename'    => 'nullable|string|max:255',
            'contact'       => 'required|string|max:20',
            'gender'        => 'required|string|max:10',
            'memberDate'    => 'nullable|date',
            'block'         => 'nullable|string|max:50',
            'barangay'      => 'nullable|string|max:100',
            'municipality'  => 'nullable|string|max:100',
            'province'      => 'nullable|string|max:100',
            'country'       => 'nullable|string|max:100',
            'validId'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'passport'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file uploads
        $validIdPath = $request->hasFile('validId') ? $request->file('validId')->store('uploads/ids', 'public') : null;
        $passportPath = $request->hasFile('passport') ? $request->file('passport')->store('uploads/passports', 'public') : null;

        // Prepare data to insert
        $data = [
            'firstname'    => $validated['firstname'],
            'lastname'     => $validated['lastname'],
            'middlename'   => $validated['middlename'] ?? null,
            'contact'      => $validated['contact'],
            'gender'       => $validated['gender'],
            'memberDate'   => $validated['memberDate'] ?? null,
            'block'        => $validated['block'] ?? null,
            'barangay'     => $validated['barangay'] ?? null,
            'municipality' => $validated['municipality'] ?? null,
            'province'     => $validated['province'] ?? null,
            'country'      => $validated['country'] ?? null,
            'validId'      => $validIdPath,
            'passport'     => $passportPath,
            'user_id'      => auth()->id(), // make sure user is logged in
        ];

        AdditionalDataModel::create($data);

        return redirect()->route('dashboard')->with('success', 'Additional data saved successfully!');
    }
}
