@extends('layouts.projects')

@section('vite')
    @vite( 'resources/js/app.js')
@endsection

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">← Back to List</a>
    </div>

    <div class="card shadow">
        <div class="row g-0">
            <div class="col-md-5">
                <img src="{{asset('storage/' . $vehicle->image)}}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="img-fluid rounded-start w-100 h-100 object-fit-cover">
            </div>
            <div class="col-md-7">
                <div class="card-body">
                    <h2 class="card-title mb-3">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>

                    <p><strong>Type:</strong> {{ $vehicle->type }}</p>
                    <p><strong>Plate:</strong> {{ $vehicle->plate }}</p>
                    <p><strong>Description:</strong><br>{{ $vehicle->description }}</p>
                    <p><strong>Price per Day:</strong> €{{ number_format($vehicle->price_per_day, 2) }}</p>

                    <p>
                        <strong>Availability:</strong>
                        <span class="badge bg-{{ $vehicle->available ? 'success' : 'danger' }}">
                            {{ $vehicle->available ? 'Available' : 'Not Available' }}
                        </span>
                    </p>

                    <div class="mt-4">
                        <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-primary">Edit Vehicle</a>
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