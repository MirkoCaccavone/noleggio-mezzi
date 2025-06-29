<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleController extends Controller
{

    //  Restituisce la lista di tutti i veicoli.

    public function index()
    {
        $vehicles = Vehicle::all(); // Recupera tutti i veicoli dal database
        return response()->json(['data' => $vehicles]); // Restituisce i dati in formato JSON
    }


    public function show(Vehicle $vehicle)
    {
        return response()->json(['data' => $vehicle]); // Restituisce i dati del veicolo in formato JSON
    }

    /**
     * Permette di cercare veicoli per marca o modello tramite una query string 'q'.
     * Esempio: /api/vehicles/search?q=ford
     */
    public function search(Request $request)
    {
        $query = Vehicle::query(); // Crea una nuova query per il modello Vehicle

        // Se è presente il parametro 'q', filtra per brand o model che contengono la stringa
        if ($request->has('q')) {
            $query->where('brand', 'like', '%' . $request->q . '%')
                ->orWhere('model', 'like', '%' . $request->q . '%');
        }

        return response()->json($query->get()); // Restituisce i risultati della ricerca in formato JSON
    }

    /**
     * Permette di filtrare i veicoli per tipo e disponibilità.
     * Esempio: /api/vehicles/filter?type=Car&available=1
     */
    public function filter(Request $request)
    {
        $query = Vehicle::query(); // Crea una nuova query per il modello Vehicle

        // Se è presente il filtro per tipo, applicalo
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Se è presente il filtro per disponibilità, applicalo
        if ($request->has('available')) {
            $query->where('available', $request->available);
        }

        return response()->json($query->get()); // Restituisce i risultati filtrati in formato JSON
    }

    // /**
    //  * Restituisce tutte le date già prenotate per un veicolo.
    //  * Utile per mostrare nel frontend i giorni non disponibili.
    //  * @param Vehicle $vehicle Il veicolo richiesto
    //  */
    public function bookedDates(Vehicle $vehicle)
    {
        // Recupera tutte le prenotazioni del veicolo (solo le date)
        $bookings = $vehicle->bookings()->get(['start_date', 'end_date']);

        $bookedDates = [];

        // Per ogni prenotazione, aggiunge tutte le date comprese tra start_date e end_date
        foreach ($bookings as $booking) {
            $current = Carbon::parse($booking->start_date);
            $end = Carbon::parse($booking->end_date);

            while ($current->lte($end)) {
                $bookedDates[] = $current->toDateString(); // Aggiunge la data nel formato 'YYYY-MM-DD'
                $current->addDay(); // Passa al giorno successivo
            }
        }

        // Restituisce tutte le date prenotate in formato JSON
        return response()->json(['booked_dates' => $bookedDates]);
    }

    /**
     * Verifica se un veicolo è disponibile in un intervallo di date richiesto.
     * Riceve in POST: vehicle_id, start_date, end_date
     * Restituisce true/false e un messaggio.
     */
    public function checkAvailability(Request $request)
    {
        // Validazione dei dati ricevuti
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date'
        ]);

        $vehicle = Vehicle::findOrFail($request->vehicle_id);

        // Se il veicolo non è disponibile (flag nel database)
        if (!$vehicle->available) {
            return response()->json([
                'available' => false,
                'message' => 'Vehicle is not available'
            ]);
        }

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Cerca prenotazioni che si sovrappongono all'intervallo richiesto
        $conflictingBookings = Booking::where('vehicle_id', $request->vehicle_id)
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate]);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
            })->get();

        $isAvailable = $conflictingBookings->isEmpty();

        // Restituisce la risposta con disponibilità e messaggio
        return response()->json([
            'available' => $isAvailable,
            'message' => $isAvailable ? 'Vehicle is available' : 'Vehicle is not available for these dates'
        ]);
    }
}
