<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $passengers = QueryBuilder::for(Passenger::class)
            ->allowedFilters(['first_name', 'last_name'])
            ->allowedSorts(['first_name', 'last_name'])
            ->paginate($request->input('per_page', 10));

        return response()->json($passengers);
    }
}
