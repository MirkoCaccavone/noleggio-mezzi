@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Add New Vehicle</h1>

    {{-- Form per la creazione di un nuovo veicolo --}}
    <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Token di sicurezza contro CSRF --}}

        {{-- Selezione del tipo di veicolo --}}
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Type --</option>
                {{-- Ciclo su tutti i tipi disponibili passati dal controller --}}
                @foreach ($types as $type)
                    <option value="{{ $type }}">{{ $type }}</option>
                @endforeach
            </select>
        </div>

        {{-- Campo per la marca del veicolo --}}
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" required>
        </div>

        {{-- Campo per il modello del veicolo --}}
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" required>
        </div>

        {{-- Campo per la targa del veicolo --}}
        <div class="mb-3">
            <label for="plate" class="form-label">Plate</label>
            <input type="text" name="plate" id="plate" class="form-control" required>
        </div>

        {{-- Campo per la descrizione del veicolo --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
        </div>

        {{-- Campo per il prezzo giornaliero --}}
        <div class="mb-3">
            <label for="price_per_day" class="form-label">Price per Day (€)</label>
            <input type="number" step="0.01" name="price_per_day" id="price_per_day" class="form-control" required>
        </div>

        {{-- Selezione della disponibilità del veicolo --}}
        <div class="mb-3">
            <label for="available" class="form-label">Available</label>
            <select name="available" id="available" class="form-select" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        {{-- Campo per il caricamento dell'immagine del veicolo --}}
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        {{-- Pulsante per inviare il form e creare il veicolo --}}
        <button type="submit" class="btn btn-primary">Create Vehicle</button>
        {{-- Pulsante per annullare e tornare alla lista --}}
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

