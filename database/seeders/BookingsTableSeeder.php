<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {
            $numBookings = rand(1, 3);

            for ($i = 0; $i < $numBookings; $i++) {
                $startDate = $faker->dateTimeBetween('+1 days', '+2 months');
                $endDate = (clone $startDate)->modify('+' . rand(1, 7) . ' days');

                Booking::create([
                    'vehicle_id' => $vehicle->id,
                    'customer_name' => $faker->name(),
                    'customer_email' => $faker->safeEmail(),
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                ]);
            }
        }
    }
}
