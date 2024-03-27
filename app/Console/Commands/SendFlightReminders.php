<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendFlightReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flight:reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send flight reminders to passengers';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get passengers who have a flight 24 hours before departure
        $passengers = DB::table('passengers')
            ->join('flight_passenger', 'passengers.id', '=', 'flight_passenger.passenger_id')
            ->join('flights', 'flight_passenger.flight_id', '=', 'flights.id')
            ->where('flights.departure_time', '<=', now()->addHours(24))
            ->where('flights.departure_time', '>', now())
            ->select('passengers.*')
            ->distinct()
            ->get();

        // Send reminder emails to passengers
        foreach ($passengers as $passenger) {
            Mail::raw("Dear {$passenger->first_name},\n\nThis is a reminder that your flight is scheduled in 24 hours.\n\nRegards,\nThe Flight Reminder System", function ($message) use ($passenger) {
                $message->to($passenger->email)->subject('Flight Reminder');
            });
        }

        $this->info("Reminder emails sent successfully.");
    }
}
