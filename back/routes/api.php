<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')
    ->resource('users', App\Http\Controllers\UserController::class)
    ->only(['index', 'show', 'create', 'store']);


Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->get('/logout', function (Request $request) {
    Route::post('logout', [AuthController::class, 'logout']);
})->name('logout');


Route::get('/', function () {
    dd("home");
})->name('home');
Route::post('/', function () {
    dd("home");
})->name('home');


Route::get('manually', function () {
    Auth::loginUsingId(1, true);
    return redirect("/api/users");
//    dd(auth()->user());
})->name('web-login');



