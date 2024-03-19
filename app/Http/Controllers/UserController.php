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
        $validatedData['password'] = bcrypt($request->input('password'));

        // Create a new user instance
        $user = User::create($validatedData);

        return response()->json($user);
    }

    public function update(Request $request, User $user)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => ['nullable', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
    ]);

    $validatedData['password'] = bcrypt($request->input('password'));
    $user->update($validatedData);
    return response()->json(['message' => 'User updated successfully']);
}

public function destroy(User $user)
{
    // Delete the user
    $user->delete();

    return response()->json(['message' => 'User deleted successfully']);
}



public function isadmin ($id){
   
    $user = User::find($id);

    // Check if the user has a specific role
    if ($user->hasRole('super-admin')) {
        // Role is assigned
        return response()->json(['message' => 'admin']);
}
    else {
        // Role is not assigned
        return response()->json(['message' => 'not admin']);
}
 
    }
    
}
