<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function index(Request $request)
    {
        $query = Passenger::query();

        // Filtering based on request parameters
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }

        if ($request->has('last_name')) {
            $query->where('last_name', 'like', '%' . $request->input('last_name') . '%');
        }

        // Sorting
        if ($request->has('sort_by') && $request->has('sort_dir')) {
            $query->orderBy($request->input('sort_by'), $request->input('sort_dir'));
        }

        // Pagination
        $perPage = $request->input('per_page', 10); // default per page
        $passengers = $query->paginate($perPage);

        return response()->json($passengers);
    }
}
