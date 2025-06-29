<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Mostra la lista di tutte le prenotazioni.
     * Permette di filtrare per data di inizio, data di fine e stato della prenotazione.
     * I risultati sono ordinati per data di inizio crescente.
     */
    public function index(Request $request)
    {
        // Prepara la query con la relazione 'vehicle' per evitare query aggiuntive nel ciclo (Eager Loading)
        $query = Booking::with('vehicle');

        // Se è stato inserito un filtro per la data di inizio, applicalo
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        // Se è stato inserito un filtro per la data di fine, applicalo
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Se è stato inserito un filtro per lo stato, applicalo solo se il valore è valido
        if ($request->filled('status') && in_array($request->status, ['pending', 'confirmed', 'cancelled'])) {
            $query->where('status', $request->status);
        }

        // Recupera tutte le prenotazioni filtrate e ordinate per data di inizio
        $bookings = $query->orderBy('start_date', 'asc')->get();

        // Passa le prenotazioni alla view
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina una prenotazione dal database.
     * Dopo l'eliminazione, reindirizza alla lista delle prenotazioni.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index');
    }
}
