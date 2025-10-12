<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdditionUserData;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/dashboard', function () {
        return Inertia::render('users/UserHomepage');
    })->name('dashboard');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateUser'])->name('profile.update');

    Route::get('/user-validate', [UserController::class, 'userValidate'])->name('user.validate');
    Route::post('/booking', [UserBookingController::class, 'store'])->name('booking');

    Route::get('/additional', [AdditionUserData::class, 'create'])->name('additional');
    Route::post('/additionalDatas', [AdditionUserData::class, 'store'])->name('additionalDatas');

    Route::get('/u', function () {
        return Inertia::render('adminUi/DashboardAdmin');
    })->name('u');

    Route::get('/air', function () {
        return Inertia::render('adminUi/Aircraft');
    })->name('air');

    Route::get('/billing', function () {
        return Inertia::render('adminUi/Billing');
    })->name('billing');

    Route::get('/bookings', function () {
        return Inertia::render('adminUi/Bookings');
    })->name('bookings');

    Route::get('/flightmanagement', function () {
        return Inertia::render('adminUi/Flight');
    })->name('flightmanagement');

    Route::get('/passenger', function () {
        return Inertia::render('adminUi/Passenger');
    })->name('passenger');

    Route::get('/routes', function () {
        return Inertia::render('adminUi/Routes');
    })->name('routes');

    Route::get('/schedule', function () {
        return Inertia::render('adminUi/Schedule');
    })->name('schedule');

    Route::get('/seat', function () {
        return Inertia::render('adminUi/Seat');
    })->name('seat');

    Route::get('/staff', function () {
        return Inertia::render('adminUi/Staff');
    })->name('staff');

    Route::post('/aircraft', [AdminController::class, 'index'])->name('aircraft');

    Route::get('/aircraftdata', [AdminController::class, 'show'])->name('aircraftdata');
});

// -----------------------------
// Include Additional Route Files
// -----------------------------
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
