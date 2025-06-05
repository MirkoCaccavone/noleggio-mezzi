<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {

        $vehiclesData = [
            'Car' => [
                'Toyota' => ['Yaris', 'Corolla', 'Camry'],
                'Ford' => ['Focus', 'Fiesta', 'Mondeo'],
                'BMW' => ['320i', 'X5', 'Z4'],
            ],
            'Scooter' => [
                'Piaggio' => ['Vespa', 'Liberty', 'Zip'],
                'Honda' => ['SH125i', 'PCX125', 'Forza'],
            ],
            'Bike' => [
                'Trek' => ['Marlin 5', 'Domane AL 3', 'FX 2'],
                'Specialized' => ['Rockhopper', 'Allez', 'Sirrus X'],
            ],
            'Van' => [
                'Mercedes' => ['Sprinter', 'Vito'],
                'Fiat' => ['Ducato', 'Scudo'],
            ],
        ];

        foreach (range(1, 30) as $i) {
            $type = $faker->randomElement(array_keys($vehiclesData));
            $brand = $faker->randomElement(array_keys($vehiclesData[$type]));
            $model = $faker->randomElement($vehiclesData[$type][$brand]);

            $vehicle = new Vehicle();
            $vehicle->type = $type;
            $vehicle->brand = $brand;
            $vehicle->model = $model;
            $vehicle->plate = strtoupper($faker->bothify('??###??'));
            $vehicle->description = $faker->sentence(10);
            $vehicle->price_per_day = $faker->randomFloat(2, 20, 150);
            $vehicle->available = $faker->boolean(80);
            $vehicle->image = $faker->imageUrl(640, 480, 'transport', true);

            $vehicle->save();
        }
    }
}
