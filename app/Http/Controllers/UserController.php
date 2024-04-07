<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        // Check if users data exists in cache
        $users = Cache::remember('users', 10, function () {
            return User::all();
        });

        return response()->json($users);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function store(Request $request)
    {
        // Validate and sanitize incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // Generate a secure password using the Str::random() method
        $validatedData['password'] = bcrypt($request->input('password'));

        // Create a new user instance
        $user = User::create($validatedData);

        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        // Validate and sanitize incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // Update password if provided
        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }

        $user->update($validatedData);

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function isadmin($id)
    {
        $user = User::find($id);

        // Check if the user exists and has a specific role
        if ($user && $user->hasRole('super-admin')) {
            return response()->json(['message' => 'admin']);
        } else {
            return response()->json(['message' => 'not admin']);
        }
    }

    // Method for exporting users to a CSV file
    public function export()
    {
        // Fetch users from the database
        $users = User::all();

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="users.csv"');
        header('Cache-Control: max-age=0');

        // Output CSV file content
        echo "Name,Email\n";
        foreach ($users as $user) {
            echo "{$user->name},{$user->email}\n";
        }

        exit;
    }
}
