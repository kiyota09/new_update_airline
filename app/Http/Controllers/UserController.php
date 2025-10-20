<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalDataModel;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
 
    public function profile()
    {
        $user = Auth::user();

        $additionalData = AdditionalDataModel::where('user_id', $user->id)->first();

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
            'contact'      => 'required|string|max:20',
            'gender'       => 'required|string|in:male,female,prefer not to say',
            'block'        => 'nullable|string|max:255',
            'barangay'     => 'nullable|string|max:255',
            'municipality' => 'nullable|string|max:255',
            'province'     => 'nullable|string|max:255',
            'country'      => 'nullable|string|max:255',
            'validId'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'passport'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $idsDir = public_path('uploads/ids');
        $passportsDir = public_path('uploads/passports');

        if (!File::exists($idsDir)) File::makeDirectory($idsDir, 0775, true);
        if (!File::exists($passportsDir)) File::makeDirectory($passportsDir, 0775, true);

    
        $additionalData = AdditionalDataModel::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        if ($request->hasFile('validId')) {
            $file = $request->file('validId');
            $filename = time() . '_validid.' . $file->getClientOriginalExtension();
            $file->move($idsDir, $filename);
            $additionalData->validId = 'uploads/ids/' . $filename;
        }

        if ($request->hasFile('passport')) {
            $file = $request->file('passport');
            $filename = time() . '_passport.' . $file->getClientOriginalExtension();
            $file->move($passportsDir, $filename);
            $additionalData->passport = 'uploads/passports/' . $filename;
        }

        $additionalData->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
