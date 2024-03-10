<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show(string $id)
{
    $user = User::findOrFail($id);
    return response()->json($user);
}



    public function addUser(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
    
        // Create a new user instance
        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();
    
        return response()->json(['message' => 'User added successfully'], 201);
    }

    public function updateUser(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
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
    
    public function deleteUser($id)
    {
        // Find the user by ID and delete
        $user = User::findOrFail($id);
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }
    
}
