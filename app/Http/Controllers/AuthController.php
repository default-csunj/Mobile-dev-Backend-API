<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['logout']);
    }
    public function register(Request $request){
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
        
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Authentication')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);

    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response([
                'message' => 'Email Not Found'
            ], 401);
        }

        if(!Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Wrong Password'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response([
            'message' => 'Logged out'
        ], 201);
    }
}
