@extends('layouts.projects')

@section('vite')
    @vite( 'resources/js/app.js')
@endsection

@section('content')

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Vehicles List</h1>
        <a href="{{ route('admin.vehicles.create') }}" class="btn btn-success">Add New Vehicle</a>
    </div>

    @if ($vehicles->count())
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
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
                @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->id }}</td>
                        <td>
                            <img src="{{asset('storage/' . $vehicle->image)}}" alt="{{ $vehicle->brand }}" style="width: 100px; height: auto;">
                        </td>
                        <td>{{ $vehicle->brand }} {{ $vehicle->model }}</td>
                        <td>{{ $vehicle->type }}</td>
                        <td>{{ $vehicle->plate }}</td>
                        <td>€{{ number_format($vehicle->price_per_day, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $vehicle->available ? 'success' : 'danger' }}">
                                {{ $vehicle->available ? 'Available' : 'Not Available' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
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
        <div class="alert alert-info">No vehicles found.</div>
    @endif
</div>
    {{-- @dump($vehicles) --}}
@endsection