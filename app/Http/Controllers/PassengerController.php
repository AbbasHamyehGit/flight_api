<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters(['id','first_name', 'last_name','date_of_birth','passport_expiry_date'])
            ->allowedSorts(['first_name', 'last_name','date_of_birth','passport_expiry_date'])
            ->paginate($request->input('per_page', 100));

        return response()->json($passengers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $passenger = Passenger::create($request->all());
        return response()->json($passenger);
    }

    /**
     * Display the specified resource.
     */
   /**
 * Display the specified resource.
 */
public function show(string $id)
{
    $passenger = Passenger::findOrFail($id);
    return response()->json($passenger);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Passenger $passenger)
    {
        $passenger->update($request->all());
        return $passenger;
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Passenger $passenger)
    {
        $passenger->delete();
        return response()->json(['message' => 'passenger deleted successfully']);
    }
}
