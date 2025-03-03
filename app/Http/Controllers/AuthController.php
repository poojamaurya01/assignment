<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:200|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        try
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('Access Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while registering the user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        try {
            $user = Auth::user();

            $token = $user->createToken('Access Token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);
        } catch (\Exception $e) {
            logger()->error("Error: " . $e->getMessage() . " on line " . $e->getLine() . " in file " . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while logging in.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
