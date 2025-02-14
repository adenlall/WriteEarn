<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Log in a user and return a token.
     */
    public function login(LoginUserRequest $request): JsonResponse
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
    public function logout(): JsonResponse
    {
        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    /**
     * Display current authenticated User.
     */
    public function user(Request $request)
    {
        return UserResource::make($request->user());
    }
}
