<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'UserData' => function () {
                return Cache::remember('UserData', 0, function () {
                    return \App\Models\User::all();
                });
            },

            'userUser' => function () {
                $user = Auth::user();
                if (!$user) {
                    return null;
                }
                $user->load('additionalData');
                return $user;
            },

            "RouteList" => function () {
                return \App\Models\RouteModel::all();
            },

            "StaffList" => function () {
                return \App\Models\StaffModel::all();
            },

            "AircraftList" => function () {
                return \App\Models\AircraftModel::all();
            },

            "history" => function () {
                return \App\Models\userHistory::all();
            },

            'user_history' => function () {
                if (!Auth::check()) {
                    return []; // if user not logged in
                }

                return DB::table('history as h')
                    ->where('h.user_id', Auth::id())
                    ->orderBy('h.created_at', 'desc')
                    ->get();
            },

            'total_income' => DB::table('history')->sum('price'),
            'total_passenger' => DB::table('history')->sum('passenger'),

            'flights_data' => function () {
                return \App\Models\Flight::all();
            }

        ]);
    }
}
