<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filtering based on request parameters
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->input('email') . '%');
        }

        // Pagination
        $perPage = $request->input('per_page', 10); // default per page
        $users = $query->paginate($perPage);

        return response()->json($users);
    }
}
