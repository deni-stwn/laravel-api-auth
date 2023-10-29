<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();


        if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                'message' => 'Login failed',
                'error' => 'email or password is incorrect'
                ], 401);
        }

            Log::info('User logged in successfully: ' . $user->email);

            $token = $user->createToken('auth_token')->plainTextToken;

            $user->makeHidden(['email', 'created_at', 'updated_at']);

        return response()->json([
            'token' => $token,
            'message' => 'Login success',
            'user' => $user
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'nullable',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user
        ], 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }

    public function me() {
        return response()->json(Auth::user());
    }
}
