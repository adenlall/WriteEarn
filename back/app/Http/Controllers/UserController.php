<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->user()->cannot('view-any', $request->user())) {
            abort(403);
        }

        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreUserRequest $request) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $request->validated();

        $want_to_create_admin = $user['role'] === 'admin';
        $can_create_admin = $request->user()?->can('store', User::make($user));

        if ($want_to_create_admin && ! $can_create_admin) {
            abort(403);
        }

        $user['password'] = Hash::make($user['password']);
        $created = User::create($user);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully.',
            'user' => $created,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }

        return UserResource::make($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (auth()->user()->cannot('update', $user)) {
            abort(403);
        }
        $user->fill($request->only(['username', 'email', 'name']));
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        if (auth()->user()->cannot('delete', $user)) {
            abort(403);
        }
        if (!Hash::check($request->password, $user->password)){
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Verification errors',
                'data' => [
                    'email'=>'Wrong password.'
                ],
            ], Response::HTTP_UNAUTHORIZED));
        }

        $user->delete();
        throw new HttpResponseException(response()->json([
            'success' => true,
            'message' => 'Account deleted successfully.',
            'data' => $user,
        ], Response::HTTP_ACCEPTED));
    }
}
