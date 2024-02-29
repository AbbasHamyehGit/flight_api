<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function index(Request $request)
    {
        $query = Flight::query();

      

        // Sorting
        if ($request->has('sort_by') && $request->has('sort_dir')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_dir'));
        }

        // Pagination
        $perPage = $request->input('per_page', 10); // default per page
        $flights = $query->paginate($perPage);

        return response()->json($flights);
    }
}
