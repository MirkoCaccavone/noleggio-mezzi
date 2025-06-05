<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::all();
        // dd($vehicles);
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = ['Car', 'Van', 'Scooter', 'Bike'];
        return view('vehicles.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $newVehicle = new Vehicle();

        $newVehicle->type = $data['type'];
        $newVehicle->brand = $data['brand'];
        $newVehicle->model = $data['model'];
        $newVehicle->plate = $data['plate'];
        $newVehicle->description = $data['description'];
        $newVehicle->price_per_day = $data['price_per_day'];
        $newVehicle->available = $data['available'];
        // $newVehicle->image = $data['image'];

        if (array_key_exists('image', $data)) {
            $img_url = Storage::putFile('uploads', $data['image']);

            $newVehicle->image = $img_url;
        }

        $newVehicle->save();

        return redirect()->route('admin.vehicles.show', $newVehicle->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $types = ['Car', 'Van', 'Scooter', 'Bike'];

        return view('vehicles.edit', compact('vehicle', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->all();

        $vehicle->type = $data['type'];
        $vehicle->brand = $data['brand'];
        $vehicle->model = $data['model'];
        $vehicle->plate = $data['plate'];
        $vehicle->description = $data['description'];
        $vehicle->price_per_day = $data['price_per_day'];
        $vehicle->available = $data['available'];
        // $vehicle->image = $data['image'];

        if (array_key_exists('image', $data)) {

            Storage::delete($vehicle->image);

            $img_url = Storage::putFile('uploads', $data['image']);

            $vehicle->image = $img_url;
        }

        $vehicle->update();

        return redirect()->route('admin.vehicles.show', $vehicle->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image) {
            Storage::delete($vehicle->image);
        }
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index');
    }
}
