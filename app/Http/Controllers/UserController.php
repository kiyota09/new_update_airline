<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalDataModel;
use Inertia\Inertia;

class UserController extends Controller
{
    public function profile()
{
    $user = Auth::user();
    $additionalData = $user->additionalData; // fetch related data correctly



    return Inertia::render('users/UserProfile', [
        'user' => $user,
        'additionalData' => $additionalData,
    ]);
}

    public function updateUser(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'firstname'    => 'required|string|max:255',
            'lastname'     => 'required|string|max:255',
            'middlename'   => 'nullable|string|max:255',
            'contact'      => 'nullable|string|max:20',
            'gender'       => 'nullable|string|in:male,female,prefer not to say',
            'block'        => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'province'     => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
        ]);

        AdditionalDataModel::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    
}
