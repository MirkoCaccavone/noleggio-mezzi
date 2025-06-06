<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// rotte per i veicoli
Route::get('/vehicles/search', [VehicleController::class, 'search']);
Route::get('/vehicles/filter', [VehicleController::class, 'filter']);
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']);
Route::get('/vehicles/{vehicle}/booked-dates', [VehicleController::class, 'bookedDates']);
Route::get('/vehicles', [VehicleController::class, 'index']);

// Rotte per le prenotazioni
Route::post('/bookings', [BookingController::class, 'store']);
Route::get('/bookings/{booking}', [BookingController::class, 'show']);
