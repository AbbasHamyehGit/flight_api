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
            ->allowedSorts(['number','departure_city', 'arrival_city', 'departure_time', 'arrival_time'])
            ->allowedFilters(['id','departure_city', 'arrival_city', 'departure_time', 'arrival_time','number'])
            ->paginate($request->input('per_page', 100));

        return response()->json($flights);
    }

    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'number' => 'required|integer|unique:flights',
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|after:departure_time',
        ];
    
        // Validate the incoming request data
        $validatedData = $request->validate($rules);
    
        // Create a new record in the database using validated data
        $flight = Flight::create($validatedData);
    
        // Return a JSON response with the created flight
        return response()->json($flight);
    }
    
    

    public function show(Request $request, Flight $flight)
    {    
        return response()->json($flight->load('passengers'));
    }

    public function update(Request $request, Flight $flight)
    {
        // Define validation rules
        $rules = [
            'number' => 'required|integer|unique:flights,number,'.$flight->id,
            'departure_city' => 'required|string|max:255',
            'arrival_city' => 'required|string|max:255',
            'departure_time' => 'required|date_format:Y-m-d H:i:s',
            'arrival_time' => 'required|date_format:Y-m-d H:i:s|after:departure_time',
        ];
    
        // Validate the incoming request data
        $validatedData = $request->validate($rules);
    
        // Update the flight record with validated data
        $flight->update($validatedData);
    
        // Return the updated flight record
        return response()->json($flight);
    }
    

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }
}
