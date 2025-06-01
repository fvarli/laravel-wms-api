<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Find user by email
        $user = User::query()->where('email', $request->email)->first();

        // If user exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            // Create random 60 character token
            $user->api_token = Str::random(60);
            $user->save();

            return response()->json([
                'token' => $user->api_token
            ]);
        }

        return response()->json([
            'error' => 'Unauthorized. Invalid email or password.'
        ], 401);
    }

    public function user(Request $request)
    {
        // Returns the authenticated user with token guard
        $user = auth()->user();
        return response()->json([
            'user' => $user
        ]);
    }


    public function logout(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            // Delete the API token
            $user->api_token = null;
            $user->save();

            return response()->json([
                'message' => 'Logout successful.'
            ]);
        }

        return response()->json([
            'error' => 'Not found or already logged out.'
        ], 401);
    }
}
