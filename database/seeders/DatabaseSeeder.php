<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Seeder;
use Database\Seeders\FlightSeeder;
use Database\Seeders\PassengerSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PassengerSeeder::class,
            FlightSeeder::class,
           
        ]);
        // Get all flights
        $flights = Flight::all();
    
        // Get all passengers
        $passengers = Passenger::all();
    
        // Loop through each flight
        $flights->each(function ($flight) use ($passengers) {
            // Randomly select a number of passengers to assign to this flight
            $numberOfPassengers = rand(15, 30); // You can adjust this range as needed
    
            // Shuffle passengers to randomize selection
            $passengersToAssign = $passengers->shuffle()->take($numberOfPassengers);
    
            // Attach passengers to this flight
            $flight->passengers()->attach($passengersToAssign);
        });
    
    }
    
}


