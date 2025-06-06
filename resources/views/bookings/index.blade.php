{{-- import layout --}}
@extends('layouts.app')


{{-- content --}}
@section('content')
<div class="container">
    <h1 class="mb-4">Lista Prenotazioni</h1>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3 mb-4 align-items-end">
        <div class="col-md-3">
            <label for="start_date" class="form-label">Data inizio:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
        </div>
        <div class="col-md-3">
            <label for="end_date" class="form-label">Data fine:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Stato:</label>
            <select name="status" id="status" class="form-select">
                <option value="">Tutti</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>In attesa</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confermate</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancellate</option>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">Filtra</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary flex-grow-1">Reset</a>
        </div>
    </form>

    @if ($bookings->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Cliente</th>
                    <th>Email</th>
                    <th>Veicolo</th>
                    <th>Data Inizio</th>
                    <th>Data Fine</th>
                    <th>Stato</th>
                    <th>Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->customer_name }}</td>
                        <td>{{ $booking->customer_email }}</td>
                        <td>{{ $booking->vehicle->brand }} {{ $booking->vehicle->model }}</td>
                        <td>{{ $booking->start_date }}</td>
                        <td>{{ $booking->end_date }}</td>
                        <td>
                            <span class="badge 
                                @if($booking->status === 'confirmed') bg-success
                                @elseif($booking->status === 'pending') bg-warning
                                @else bg-danger
                                @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                        <td>
                            {{-- <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a> --}}
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Sei sicuro di voler cancellare questa prenotazione?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Non ci sono prenotazioni al momento.</p>
    @endif
</div>
@endsection