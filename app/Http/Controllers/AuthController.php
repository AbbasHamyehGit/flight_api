<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json($user);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        if (Auth::check()) {
            // User is authenticated
            return response()->json(['message' => 'can not logout ']);
        } else {
            // User is not authenticated
            return response()->json(['message' => 'Logged out successfully']);
        }

        
    }
}
