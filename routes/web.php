<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdditionUserData;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserDatasController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\locationDestinationController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\userHistoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'verified', 'no-cache'])->group(function () {

    Route::get('/dashboard', function () {

        return Inertia::render('users/UserHomepage');
    })->name('dashboard');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateUser'])->name('profile.update');

    Route::get('/user-validate', [UserController::class, 'userValidate'])->name('user.validate');
    Route::post('/booking', [UserBookingController::class, 'store'])->name('booking');

    Route::get('/additional', [AdditionUserData::class, 'create'])->name('additional');
    Route::post('/additionalDatas', [AdditionUserData::class, 'store'])->name('additionalDatas');

    Route::get('/u', [UserDatasController::class, 'showUser'])->name('u');

    Route::post('/aircraft', [AdminController::class, 'index'])->name('aircraft');

    Route::get('/air', [AdminController::class, 'show'])->name('air');

    Route::get('/booking', function () {
        return Inertia::render('adminUi/Bookings');
    });

    Route::get('/routess', function () {
        return Inertia::render('adminUi/Routes');
    });

    Route::get('/schedule', function () {
        return Inertia::render('adminUi/Schedule');
    });

    Route::get('/staff', function () {
        return Inertia::render('adminUi/Staff');
    });

    Route::get('/passenger', function () {
        return Inertia::render('adminUi/Passenger');
    });

    Route::get('/billing', function () {
        return Inertia::render('adminUi/Billing');
    });

    Route::get('/seat', function () {
        return Inertia::render('adminUi/Seat');
    });

    Route::get('/flightmanagement', function () {
        return Inertia::render('adminUi/Flightmanagement');
    });

    Route::get('/mybooking', function () {
        return Inertia::render('users/MyBookings');
    });

    Route::post('/route_location', [RouteController::class, 'store'])->name('route_location');

    Route::put('/routes/{id}', [RouteController::class, 'update'])->name('routes.update');

    Route::delete('/route_location/{id}', [RouteController::class, 'destroy'])->name('routes.delete');

    Route::get('/admin/schedule', [FlightController::class, 'index']);

    Route::get('/admin/schedule/json', [FlightController::class, 'apiIndex']);

    Route::post('/admin/schedule', [FlightController::class, 'store']);

    Route::put('/admin/schedule/{flight}', [FlightController::class, 'update']);

    Route::delete('/admin/schedule/{flight}', [FlightController::class, 'destroy']);

    Route::post('/staff_submit', [StaffController::class, 'store'])->name('staff_submit');

    Route::post('/search_destination', [locationDestinationController::class, 'search_avial'])->name('search_destination');

    Route::post('/price_destination', [locationDestinationController::class, 'selected_price'])->name('price_destination');


Route::get('/payment-success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment-failed', [PaymentController::class, 'paymentFailed'])->name('payment.failed');

    Route::post('/create-payment-intent', [PaymentController::class, 'try']);

    Route::get('/payment', function(){
       return Inertia::render('users/payment');
    });

    Route::post('/userHistory',[userHistoryController::class , 'submitTransac'])->name('userHistory');
});

// -----------------------------
// Include Additional Route Files
// -----------------------------
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
