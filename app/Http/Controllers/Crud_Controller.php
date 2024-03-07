<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class Crud_Controller extends Controller
{
    public function index()
    {
        return Flight::all();
    }

    public function store(Request $request)
{
    $flight = Flight::create($request->all());
    return response()->json(['message' => 'Flight created successfully', 'flight' => $flight], 201);
}


    public function show(Flight $flight)
    {
        return $flight;
    }

    public function update(Request $request, Flight $flight)
    {
        $flight->update($request->all());
        return $flight;
        
    }

    public function destroy(Flight $flight)
    {
        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }
}
