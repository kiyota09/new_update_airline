<?php

use App\Http\Controllers\Auth\AdditionUserData;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
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
});

// Include additional route files
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
