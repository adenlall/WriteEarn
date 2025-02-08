<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(StoreUserRequest $request)
    {
        $user = $request->validated();
        $user['password'] = Hash::make($user['password']);
        $created = User::create($user);

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $created,
        ], 201);
    }

    /**
     * Log in a user and return a token.
     */
    public function login(LoginUserRequest $request)
    {
        $request->validated();

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Verification errors',
                'data' => [
                    'email'=>'Wrong email or password.'
                ],
            ], Response::HTTP_UNAUTHORIZED));
        }

        $token = $user->createToken('auth-api-token')->plainTextToken;
        return response()->json([
            'message' => 'Logged in successfully.',
            'token' => $token,
        ]);
    }

    /**
     * Log out the user and revoke the token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
