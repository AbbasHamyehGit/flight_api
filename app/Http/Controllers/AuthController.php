<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'msg' => 'incorrect username or password'
            ], 401);
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
    // if (auth()->check()) {
    //     $user = $request->user();
    //     $user->tokens()->delete();

    //     return response()->json(['message' => $user->name . ' Logged out successfully']);
    // } else {
    //     return response()->json(['error' => 'Unauthorized'], 401);
    // }
    
    auth()->user()->tokens()->delete();
    return [
        'message' => 'user logged out'
    ];


}

}
