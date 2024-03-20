<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
      
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user) {
                $token = Str::random(60); // Generate a random token
                $user->remember_token = hash('sha256', $token); // Store the token in the remember_token column
                $user->save(); // Save the user instance to persist the changes
                return response()->json(['message' => 'Logged in successfully', 'token' => $token,'user '=>$user]);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = $request->user();
            $user->remember_token = null; // Clear the remember_token column
            $user->save(); // Save the user instance to persist the changes
            Auth::logout();
            return response()->json(['message' => $user->name.' Logged out successfully']);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
