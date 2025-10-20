<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\AdditionalDataModel;
use Illuminate\Support\Facades\File;

class AdditionUserData extends Controller
{
    public function create(): Response
    {
        $userId = auth()->id();
        $userData = AdditionalDataModel::where('user_id', $userId)->first();

        return Inertia::render('auth/AdditionUserData', [
            'additionalData' => $userData,
        ]);
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

    $userId = auth()->id();
    $data = AdditionalDataModel::firstOrNew(['user_id' => $userId]);

    $idsDir = public_path('uploads/ids');
    $passportsDir = public_path('uploads/passports');
    if (!file_exists($idsDir)) mkdir($idsDir, 0775, true);
    if (!file_exists($passportsDir)) mkdir($passportsDir, 0775, true);

    if ($request->hasFile('validId')) {
        if ($data->validId && file_exists(public_path($data->validId))) {
            unlink(public_path($data->validId));
        }
        $file = $request->file('validId');
        $filename = time() . '_validid.' . $file->getClientOriginalExtension();
        $file->move($idsDir, $filename);
        $data->validId = 'uploads/ids/' . $filename;
    }


    if ($request->hasFile('passport')) {

        if ($data->passport && file_exists(public_path($data->passport))) {
            unlink(public_path($data->passport));
        }
        $file = $request->file('passport');
        $filename = time() . '_passport.' . $file->getClientOriginalExtension();
        $file->move($passportsDir, $filename);
        $data->passport = 'uploads/passports/' . $filename;
    }


    $data->firstname    = $validated['firstname'];
    $data->lastname     = $validated['lastname'];
    $data->middlename   = $validated['middlename'] ?? null;
    $data->contact      = $validated['contact'];
    $data->gender       = $validated['gender'];
    $data->memberDate   = $validated['memberDate'] ?? null;
    $data->block        = $validated['block'] ?? null;
    $data->barangay     = $validated['barangay'] ?? null;
    $data->municipality = $validated['municipality'] ?? null;
    $data->province     = $validated['province'] ?? null;
    $data->country      = $validated['country'] ?? null;

    $data->save();

    return redirect()->route('dashboard')->with('success', 'Profile updated successfully!');
}

}
