<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class BookingsTableSeeder extends Seeder
{
    /**
     * Popola la tabella bookings con dati fittizi.
     */
    public function run(Faker $faker): void
    {
        $vehicles = Vehicle::all();

        // Per ogni veicolo presente nel database...
        foreach ($vehicles as $vehicle) {
            // Genera un numero casuale di prenotazioni da creare per questo veicolo (tra 1 e 3)
            $numBookings = rand(1, 3);

            // Crea effettivamente le prenotazioni per questo veicolo
            for ($i = 0; $i < $numBookings; $i++) {
                // Genera una data di inizio casuale tra domani e due mesi da oggi
                $startDate = $faker->dateTimeBetween('+1 days', '+2 months');
                // Genera una data di fine aggiungendo da 1 a 7 giorni alla data di inizio
                $endDate = (clone $startDate)->modify('+' . rand(1, 7) . ' days');

                // Crea una nuova prenotazione nel database con dati fittizi
                Booking::create([
                    'vehicle_id' => $vehicle->id, // Associa la prenotazione al veicolo corrente
                    'customer_name' => $faker->name(), // Nome cliente generato casualmente
                    'customer_email' => $faker->safeEmail(), // Email cliente generata casualmente
                    'start_date' => $startDate->format('Y-m-d'), // Data inizio in formato YYYY-MM-DD
                    'end_date' => $endDate->format('Y-m-d'),     // Data fine in formato YYYY-MM-DD
                    'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']), // Stato casuale
                ]);
            }
        }
    }
}
