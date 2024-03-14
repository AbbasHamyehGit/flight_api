<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(){
    
        return response()->json(User::all());
    }
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
            'password' => ['required', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        // Generate a secure password using the Str::random() method
        $validatedData['password'] = bcrypt($request->password);

        // Create a new user instance
        $user = User::create($validatedData);

        return response()->json(['message' => 'User added successfully']);
    }

    public function update(Request $request, User $user)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
    ]);

    // Update user information
    $user->update($validatedData);
    if ($request->has('password')) {
        $user->password = bcrypt($request->password);
    }
    $user->save();

    return response()->json(['message' => 'User updated successfully']);
}

public function destroy(User $user)
{
    // Delete the user
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}

}
