@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1>Edit Vehicle</h1>

    {{-- Form per modificare un veicolo esistente --}}
    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Token di sicurezza contro CSRF --}}
        @method('PUT') {{-- Metodo HTTP PUT per aggiornare il veicolo --}}

        {{-- Selezione del tipo di veicolo --}}
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Type --</option>
                {{-- Ciclo su tutti i tipi disponibili e seleziona quello attuale --}}
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ $vehicle->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        {{-- Campo per la marca del veicolo --}}
        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ $vehicle->brand }}" required>
        </div>

        {{-- Campo per il modello del veicolo --}}
        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ $vehicle->model }}" required>
        </div>

        {{-- Campo per la targa del veicolo --}}
        <div class="mb-3">
            <label for="plate" class="form-label">Plate</label>
            <input type="text" name="plate" id="plate" class="form-control" value="{{ $vehicle->plate }}" required>
        </div>

        {{-- Campo per la descrizione del veicolo --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ $vehicle->description }}</textarea>
        </div>

        {{-- Campo per il prezzo giornaliero --}}
        <div class="mb-3">
            <label for="price_per_day" class="form-label">Price per Day (€)</label>
            <input type="number" step="0.01" name="price_per_day" id="price_per_day" class="form-control" value="{{ $vehicle->price_per_day }}" required>
        </div>

        {{-- Selezione della disponibilità del veicolo --}}
        <div class="mb-3">
            <label for="available" class="form-label">Available</label>
            <select name="available" id="available" class="form-select" required>
                <option value="1" {{ $vehicle->available ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$vehicle->available ? 'selected' : '' }}>No</option>
            </select>
        </div>

        {{-- Gestione dell'immagine del veicolo --}}
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            {{-- Se il veicolo ha già un'immagine, mostra l'anteprima e il checkbox per rimuoverla --}}
            @if($vehicle->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Preview" style="max-height: 200px; max-width: 200px;">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                        <label for="remove_image" class="form-check-label">Remove current image</label>
                    </div>
                </div>
            @endif
            {{-- Campo per caricare una nuova immagine --}}
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Pulsante per salvare le modifiche --}}
        <button type="submit" class="btn btn-success">Update Vehicle</button>
        {{-- Pulsante per annullare e tornare alla lista --}}
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

