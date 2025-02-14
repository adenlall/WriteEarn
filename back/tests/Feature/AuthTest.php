<?php

use App\Http\Resources\UserResource;
use App\Models\User;
use Faker\Factory;
use Illuminate\Support\Facades\Hash;

describe('register', function () {
    it('return general validation errors', function () {
        $success = ['success' => false];
        $response = $this->post('/api/register');
        $response->assertStatus(422);
        $response->assertJson($success);
    });

    it('return email already exists', function () {
        $success = ['success' => false];
        $response = $this->post('/api/register', [
            'email' => User::first()->email, // already existing in the DB
            'password' => Factory::create()->password,
            'name' => Factory::create()->name,
            'username' => Factory::create()->userName,
            'role' => 'reader',
        ]);
        $response->assertStatus(422);
        $response->assertJson($success);
    });

    it('return permissions errors', function () {
        $response = $this->post('/api/register', [
            'email' => Factory::create()->email,
            'password' => Factory::create()->password,
            'name' => Factory::create()->name,
            'username' => Factory::create()->userName,
            'role' => 'admin',
        ]);
        expect($response->status())->toBeIn([422, 403]);
    });

    it('return success response', function () {
        $userData = [
            'email' => Factory::create()->userName.'.'.Factory::create()->companyEmail,
            'password' => Factory::create()->password(9),
            'name' => Factory::create()->name,
            'username' => Factory::create()->userName.'.'.Factory::create()->userName,
            'role' => 'reader',
        ];
        $response = $this->post('/api/register', $userData);
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'user' => User::where('email', $userData['email'])->first()->toArray(),
        ]);
    });

});

describe('login', function () {

    it('return wrong credentials', function () {
        $user = User::factory()->create();
        $userData = [
            'email' => $user->email,
            'password' => Factory::create()->password,
        ];
        $response = $this->post('/api/login', $userData);
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
        ]);
    });

    it('return success response', function () {
        $user = User::factory()->create([
            'password' => Hash::make('pass123@@3'),
        ]);
        $userData = [
            'email' => $user->email,
            'password' => 'pass123@@3',
        ];
        $response = $this->post('/api/login', $userData);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token', 'message',
        ]);
    });

});

describe('auth', function () {
    it('return auth by token', function () {
        $user = User::factory()->create([
            'password' => Hash::make('pass123@@3'),
        ]);
        $login_response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'pass123@@3',
        ]);
        $login_response->assertStatus(200);
        $token = $login_response->json()['token'];

        $auth_response = $this->get('/api/auth', headers: [
            'Authorization' => "Bearer $token",
        ]);
        $auth = new UserResource($user);
        $auth_response->assertJson($auth->response()->getData(true));
    });

    it('return error when wrong token', function () {
        $response = $this->get('/api/auth', headers: [
            'Authorization' => 'Bearer 338198312983712137192321',
        ]);
        expect($response->status())->toBeIn([401, 302]);
    });
});
