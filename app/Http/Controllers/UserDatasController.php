<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;

class UserDatasController extends Controller
{
    public function showUser(){
        $UserData = User::all();

        return Inertia::render('adminUi/DashboardAdmin',['UserData' => $UserData]);
    }
}
