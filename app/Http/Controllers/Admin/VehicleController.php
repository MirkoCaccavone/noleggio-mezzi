<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Mostra la lista di tutti i veicoli.
     * Permette anche di filtrare per tipo di veicolo tramite richiesta GET.
     */
    public function index(Request $request)
    {
        $types = ['Car', 'Van', 'Scooter', 'Bike']; // Tipi di veicoli disponibili per il filtro

        // Se è stato richiesto un filtro per tipo, applicalo
        if ($request->type) {
            $vehicles = Vehicle::where('type', $request->type)->get();
        } else {
            $vehicles = Vehicle::all();
        }

        // Restituisce la view con i dati dei veicoli e dei tipi disponibili
        return view('vehicles.index', compact('vehicles', 'types'));
    }





    /**
     * Mostra il form per la creazione di un nuovo veicolo.
     */
    public function create()
    {
        $types = ['Car', 'Van', 'Scooter', 'Bike']; // Tipi di veicoli disponibili
        return view('vehicles.create', compact('types'));
    }





    /**
     * Salva un nuovo veicolo nel database.
     * Gestisce anche l'upload dell'immagine se presente.
     */
    public function store(Request $request)
    {
        $data = $request->all(); // Recupera tutti i dati inviati dal form

        $newVehicle = new Vehicle();

        // Assegna i dati ricevuti dal form ai campi del modello
        $newVehicle->type = $data['type'];
        $newVehicle->brand = $data['brand'];
        $newVehicle->model = $data['model'];
        $newVehicle->plate = $data['plate'];
        $newVehicle->description = $data['description'];
        $newVehicle->price_per_day = $data['price_per_day'];
        $newVehicle->available = $data['available'];

        // Se è stata caricata un'immagine, la salva nello storage e aggiorna il campo image
        if (array_key_exists('image', $data)) {
            $img_url = Storage::putFile('uploads', $data['image']);
            $newVehicle->image = $img_url;
        }

        $newVehicle->save(); // Salva il nuovo veicolo nel database

        // Reindirizza alla pagina di dettaglio del veicolo appena creato
        return redirect()->route('admin.vehicles.show', $newVehicle->id);
    }





    /**
     * Mostra i dettagli di un singolo veicolo.
     */
    public function show(Vehicle $vehicle)
    {
        // Passa il veicolo alla view di dettaglio
        return view('vehicles.show', compact('vehicle'));
    }





    /**
     * Mostra il form di modifica di un veicolo esistente.
     */
    public function edit(Vehicle $vehicle)
    {
        $types = ['Car', 'Van', 'Scooter', 'Bike']; // Tipi di veicoli disponibili
        // Passa il veicolo e i tipi alla view di modifica
        return view('vehicles.edit', compact('vehicle', 'types'));
    }





    /**
     * Aggiorna i dati di un veicolo esistente nel database.
     * Gestisce anche la sostituzione o rimozione dell'immagine.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->all(); // Recupera tutti i dati inviati dal form

        // Aggiorna i campi del veicolo con i nuovi dati
        $vehicle->type = $data['type'];
        $vehicle->brand = $data['brand'];
        $vehicle->model = $data['model'];
        $vehicle->plate = $data['plate'];
        $vehicle->description = $data['description'];
        $vehicle->price_per_day = $data['price_per_day'];
        $vehicle->available = $data['available'];

        // Gestione immagine: sostituzione o rimozione
        if (array_key_exists('image', $data)) {
            // Se esiste già un'immagine, la elimina dallo storage
            if ($vehicle->image) {
                Storage::delete($vehicle->image);
            }
            // Salva la nuova immagine e aggiorna il campo image
            $img_url = Storage::putFile('uploads', $data['image']);
            $vehicle->image = $img_url;
        } elseif ($request->has('remove_image') && $vehicle->image) {
            // Se è stato selezionato il checkbox per rimuovere l'immagine, la elimina
            Storage::delete($vehicle->image);
            $vehicle->image = null;
        }

        $vehicle->update(); // Salva le modifiche nel database

        // Reindirizza alla pagina di dettaglio aggiornata
        return redirect()->route('admin.vehicles.show', $vehicle->id);
    }




    /**
     * Elimina un veicolo dal database e cancella l'immagine associata se presente.
     */
    public function destroy(Vehicle $vehicle)
    {
        // Se il veicolo ha un'immagine associata, la elimina dallo storage
        if ($vehicle->image) {
            Storage::delete($vehicle->image);
        }
        $vehicle->delete(); // Elimina il veicolo dal database
        // Reindirizza alla lista dei veicoli
        return redirect()->route('admin.vehicles.index');
    }
}
