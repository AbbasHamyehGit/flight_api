<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'invalid credentials']);
          //  throw new AuthenticationException('Invalid credentials');
        }

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];

        return response($res, 201);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
    
        return response()->json(['message' => 'Logged out successfully']);
    }
// public function logout(Request $request)
// {
//     // Retrieve the user's tokens from the database
//     $tokens = PersonalAccessToken::where('tokenable_type', 'App\Models\User')
//         ->whereIn('token', $request->bearerToken())
//         ->get();

//     // Delete each token
//     foreach ($tokens as $token) {
//         $token->delete();
//     }

//     // Return a success message
//     return [
//         'message' => 'user logged out'
//     ];
// }

}