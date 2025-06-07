@extends('layouts.app')


@section('content')
<div class="container py-5">
    <h1>Edit Vehicle</h1>

    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Select Type --</option>
                @foreach ($types as $type)
                    <option value="{{ $type }}" {{ $vehicle->type === $type ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ $vehicle->brand }}" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ $vehicle->model }}" required>
        </div>

        <div class="mb-3">
            <label for="plate" class="form-label">Plate</label>
            <input type="text" name="plate" id="plate" class="form-control" value="{{ $vehicle->plate }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" rows="4" class="form-control" required>{{ $vehicle->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price_per_day" class="form-label">Price per Day (€)</label>
            <input type="number" step="0.01" name="price_per_day" id="price_per_day" class="form-control" value="{{ $vehicle->price_per_day }}" required>
        </div>

        <div class="mb-3">
            <label for="available" class="form-label">Available</label>
            <select name="available" id="available" class="form-select" required>
                <option value="1" {{ $vehicle->available ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$vehicle->available ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            @if($vehicle->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="Preview" style="max-height: 200px; max-width: 200px;">
                    <div class="form-check mt-2">
                        <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                        <label for="remove_image" class="form-check-label">Remove current image</label>
                    </div>
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Vehicle</button>
        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

