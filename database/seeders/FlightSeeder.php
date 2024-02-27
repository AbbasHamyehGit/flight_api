<?php
namespace Database\Seeders;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Flight;


class FlightSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            Flight::create([
                'number' => $faker->unique()->regexify('[A-Z0-9]{5}'),
                'departure_city' => $faker->city,
                'arrival_city' => $faker->city,
                'departure_time' => $faker->dateTimeBetween('+1 days', '+1 week'),
                'arrival_time' => $faker->dateTimeBetween('+1 week', '+2 weeks'),
            ]);
        }
    }
}