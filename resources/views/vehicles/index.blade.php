{{-- Importa il layout principale --}}
@extends('layouts.app')

{{-- Sezione del contenuto principale --}}
@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">

        {{-- Titolo della pagina --}}
        <h1>Vehicles List</h1>

        {{-- Bottone per aggiungere un nuovo veicolo --}}
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-success">Add New Vehicle</a>
    </div>
    
    {{-- Form per filtrare i veicoli per tipo --}}
    <form action="{{ route('admin.vehicles.index') }}" method="GET" class="mb-3">
        <div class="row">
            <div class="col-auto">
                {{-- Select per scegliere il tipo di veicolo da filtrare --}}
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    {{-- Ciclo su tutti i tipi disponibili e seleziona quello scelto --}}
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                {{-- Bottone per applicare il filtro --}}
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    {{-- Se ci sono veicoli da mostrare --}}
    @if ($vehicles->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Brand / Model</th>
                    <th>Type</th>
                    <th>Plate</th>
                    <th>Price / day</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {{-- Ciclo su tutti i veicoli e mostro una riga per ciascuno --}}
                @foreach ($vehicles as $vehicle)
                    <tr>
                        {{-- Colonna immagine veicolo --}}
                        <td>
                            <img src="{{asset('storage/' . $vehicle->image)}}" alt="{{ $vehicle->brand }}" style="width: 100px; height: auto;">
                        </td>
                        {{-- Colonna marca e modello --}}
                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                        {{-- Colonna tipo --}}
                        <td>{{ $vehicle->type }}</td>
                        {{-- Colonna targa (se non è una bici, altrimenti N.D) --}}
                        <td>
                            {{ $vehicle->type != 'Bike' ? $vehicle->plate : 'N.D' }}
                        </td>
                        {{-- Colonna prezzo al giorno --}}
                        <td>€{{ number_format($vehicle->price_per_day, 2) }}</td>
                        {{-- Colonna disponibilità con badge colorato --}}
                        <td>
                            <span class="badge bg-{{ $vehicle->available ? 'success' : 'danger' }}">
                                {{ $vehicle->available ? 'Available' : 'Not Available' }}
                            </span>
                        </td>
                        {{-- Colonna azioni: visualizza, modifica, elimina --}}
                        <td>
                            {{-- Bottone per visualizzare i dettagli --}}
                            <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-info mx-1">View</a>
                            {{-- Bottone per modificare il veicolo --}}
                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-primary mx-1">Edit</a>
                            {{-- Form per eliminare il veicolo con conferma --}}
                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger mx-1">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Messaggio se non ci sono veicoli --}}
        <div class="alert alert-info">No vehicles found.</div>
    @endif
</div>
{{-- Debug: mostra i dati dei veicoli (commentato) --}}
{{-- @dump($vehicles) --}}
@endsection