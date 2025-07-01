<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user' // default sebagai user
        ]);

        return response()->json([
            'message' => 'Register success, please login.',
            'user'    => $user,
        ], 201);
    }


    public function login(Request $request)
    {
        try {
            // Manual validasi
            $validator = \Validator::make($request->all(), [
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation error',
                    'errors'  => $validator->errors(),
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (! $user || ! \Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Login failed',
                    'errors'  => ['email' => ['The provided credentials are incorrect.']],
                ], 422);
            }

            if ($user->role !== 'user') {
                return response()->json([
                    'message' => 'Only user can login from mobile.'
                ], 403);
            }

            $token = $user->createToken('mobile-token')->plainTextToken;

            return response()->json([
                'message' => 'Login success',
                'user'    => $user,
                'token'   => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function profile(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Unauthenticated.'
                ], 401);
            }

            return response()->json([
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
