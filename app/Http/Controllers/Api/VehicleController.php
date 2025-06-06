<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return response()->json(['data' => $vehicles]);
    }


    public function show(Vehicle $vehicle)
    {
        return response()->json(['data' => $vehicle]);
    }


    public function search(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('q')) {
            $query->where('brand', 'like', '%' . $request->q . '%')
                ->orWhere('model', 'like', '%' . $request->q . '%');
        }

        return response()->json($query->get());
    }


    public function filter(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('available')) {
            $query->where('available', $request->available);
        }

        return response()->json($query->get());
    }


    public function bookedDates(Vehicle $vehicle)
    {
        $bookings = $vehicle->bookings()->get(['start_date', 'end_date']);

        $bookedDates = [];

        foreach ($bookings as $booking) {
            $current = \Carbon\Carbon::parse($booking->start_date);
            $end = \Carbon\Carbon::parse($booking->end_date);

            while ($current->lte($end)) {
                $bookedDates[] = $current->toDateString(); // formato 'YYYY-MM-DD'
                $current->addDay();
            }
        }

        return response()->json($bookedDates);
    }
}
