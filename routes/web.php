<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Route::middleware('role:manager')->group(function () {
    //     Route::post('/bookings/requests', [BookingController::class, 'requests'])->name('bookings.requests');
    //     Route::post('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    //     Route::post('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
    // });

    // Route::middleware('role:admin')->group(function () {
        Route::resource('types', TypeController::class);
        Route::resource('items', ItemController::class);
        Route::resource('emails', EmailController::class);
        Route::resource('users', UserController::class);
    // });

    Route::resource('bookings', BookingController::class);

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});