<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

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
        ]);
    }
}
