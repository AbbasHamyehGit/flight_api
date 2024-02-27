<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\Passenger;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PassengerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 1000; $i++) {
            Passenger::create([
                'FirstName' => $faker->firstName,
                'LastName' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'), 
                'DOB' => $faker->date,
                'passport_expiry_date' => $faker->date,
            ]);
        }
    }
    
}
