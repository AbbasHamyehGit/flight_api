<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $departure_time = $faker->dateTimeBetween('+1 days', '+1 week');
            
            // Calculate maximum arrival time (1 day after departure)
            $maxArrivalTime = clone $departure_time;
            $maxArrivalTime->modify('+1 day');

            // Generate arrival time within the range
            $arrival_time = $faker->dateTimeBetween($departure_time, $maxArrivalTime);

            Flight::create([
                'number' => $faker->unique()->regexify('[0-9]{2}[0-9]{3,4}'),
                'departure_city' => $faker->city,
                'arrival_city' => $faker->city,
                'departure_time' => $departure_time,
                'arrival_time' => $arrival_time,
            ]);
        }
    }
}
