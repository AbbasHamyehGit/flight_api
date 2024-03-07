<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $flights = QueryBuilder::for(Flight::class)
            ->allowedSorts(['departure_city', 'arrival_city', 'departure_time', 'arrival_time'])
            ->allowedFilters(['id','departure_city', 'arrival_city', 'departure_time', 'arrival_time','number'])
            ->paginate($request->input('per_page', 100));

        return response()->json($flights);
    }

    public function show(Request $request, Flight $flight)
    {
        $passengers = $flight->passengers()->get();
    
        // Include flight details along with passengers
        $flightData = [
            'flight' => $flight,
            'passengers' => $passengers,
        ];
    
        return response()->json($flightData);
    }
    
}
