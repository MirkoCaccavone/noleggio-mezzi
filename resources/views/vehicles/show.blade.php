@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Pulsante per tornare alla lista dei veicoli --}}
    <div class="mb-4">
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">← Back to List</a>
    </div>

    {{-- Card che mostra i dettagli del veicolo --}}
    <div class="card shadow">
        <div class="row g-0">
            {{-- Colonna immagine veicolo --}}
            <div class="col-md-5">
                <img src="{{asset('storage/' . $vehicle->image)}}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="img-fluid rounded-start w-100 h-100 object-fit-cover">
            </div>
            {{-- Colonna dettagli veicolo --}}
            <div class="col-md-7">
                <div class="card-body">
                    {{-- Titolo: marca e modello --}}
                    <h2 class="card-title mb-3">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>

                    {{-- Tipo di veicolo --}}
                    <p><strong>Type:</strong> {{ $vehicle->type }}</p>
                    {{-- Targa --}}
                    <p><strong>Plate:</strong> {{ $vehicle->plate }}</p>
                    {{-- Descrizione --}}
                    <p><strong>Description:</strong><br>{{ $vehicle->description }}</p>
                    {{-- Prezzo giornaliero --}}
                    <p><strong>Price per Day:</strong> €{{ number_format($vehicle->price_per_day, 2) }}</p>

                    {{-- Disponibilità con badge colorato --}}
                    <p>
                        <strong>Availability:</strong>
                        <span class="badge bg-{{ $vehicle->available ? 'success' : 'danger' }}">
                            {{ $vehicle->available ? 'Available' : 'Not Available' }}
                        </span>
                    </p>

                    {{-- Azioni: modifica o elimina veicolo --}}
                    <div class="mt-4">
                        {{-- Bottone per modificare il veicolo --}}
                        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-primary">Edit Vehicle</a>
                        {{-- Form per eliminare il veicolo con conferma --}}
                        <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection