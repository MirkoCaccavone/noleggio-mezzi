<?php
// Definizione delle rotte API per l'applicazione Laravel

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\VehicleController;
use Illuminate\Support\Facades\Route;

// Rotte per i veicoli 
Route::get('/vehicles/search', [VehicleController::class, 'search']); // Ricerca per marca o modello
Route::get('/vehicles/filter', [VehicleController::class, 'filter']); // Filtro per tipo/disponibilità
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show']); // Dettaglio veicolo
Route::get('/vehicles/{vehicle}/booked-dates', [VehicleController::class, 'bookedDates']); // Date prenotate
Route::get('/vehicles', [VehicleController::class, 'index']); // Lista veicoli

// Rotte per le prenotazioni 
Route::post('/bookings', [BookingController::class, 'store']); // Crea prenotazione
Route::get('/bookings/{booking}', [BookingController::class, 'show']); // Dettaglio prenotazione
