<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
    Route::resource('blogs', App\Http\Controllers\BlogController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});

Route::post('register', [App\Http\Controllers\UserController::class, 'store'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('auth', [AuthController::class, 'user']);
})->name('logout');

Route::get('/', function () {
    dd('home');
})->name('home');
Route::post('/', function () {
    dd('home');
})->name('home');

Route::get('manually', function () {
    Auth::loginUsingId(1, true);

    return redirect('/api/users');
    //    dd(auth()->user());
})->name('web-login');
