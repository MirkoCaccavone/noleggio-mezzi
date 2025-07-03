<?php
// Definizione delle rotte web dell'applicazione Laravel

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotta per la homepage 
Route::get('/', function () {
    return view('welcome');
});

// Rotta per la dashboard utente, accessibile solo se autenticato e verificato
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotte per la gestione del profilo utente
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotte per l'area amministrativa (dashboard, profilo admin, veicoli, prenotazioni)
Route::middleware((['auth', 'verified']))
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {

        // Dashboard amministratore
        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');

        // Profilo amministratore
        Route::get('/profile', [DashboardController::class, 'profile'])
            ->name('profile');

        // CRUD veicoli
        Route::resource('vehicles', VehicleController::class);
        // ->middleware(['auth', 'verified']);

        // CRUD prenotazioni
        Route::resource('bookings', BookingController::class);
        // ->middleware(['auth', 'verified']);
    });

// Rotte di autenticazione (login, register, ecc.)
require __DIR__ . '/auth.php';
