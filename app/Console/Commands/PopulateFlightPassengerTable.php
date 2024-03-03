<?php

namespace App\Console\Commands;

use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Console\Command;

class PopulateFlightPassengerTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-flight-passenger-table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate flight_passenger table with random passengers for each flight';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
    
        $this->info('Flight-passenger population completed successfully!');
    }
    
}
