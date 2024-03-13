<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
    
        return response()->json($user);
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Hash the password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Create a new user instance
        $user = User::create($validatedData);

        return response()->json(['message' => 'User added successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update user information
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->has('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}

