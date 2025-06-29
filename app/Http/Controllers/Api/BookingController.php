<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Crea una nuova prenotazione.
     * Riceve i dati tramite una richiesta POST e li valida.
     * Se la validazione va a buon fine, crea una nuova prenotazione nel database.
     */
    public function store(Request $request)
    {
        // Validazione dei dati ricevuti dalla richiesta
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id', // Deve esistere un veicolo con questo ID
            'customer_name' => 'required|string',          // Nome del cliente obbligatorio
            'customer_email' => 'required|email',          // Email del cliente obbligatoria e valida
            'start_date' => 'required|date|after:today',   // Data inizio obbligatoria, deve essere futura
            'end_date' => 'required|date|after:start_date' // Data fine obbligatoria, dopo la data inizio
        ]);

        // Crea la prenotazione nel database usando i dati validati
        $booking = Booking::create($validated);

        // Restituisce la prenotazione creata in formato JSON e codice 201 (Created)
        return response()->json($booking, 201);
    }


    // Mostra i dettagli di una singola prenotazione.

    public function show(Booking $booking)
    {
        // Restituisce la prenotazione in formato JSON
        return response()->json($booking);
    }
}
