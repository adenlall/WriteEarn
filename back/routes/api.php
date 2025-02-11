<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'users' => App\Http\Controllers\UserController::class,
        'blogs' => App\Http\Controllers\BlogController::class,
        'blogs.posts' => App\Http\Controllers\PostController::class,
    ]);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('auth', [AuthController::class, 'user'])->name('auth');
});

Route::post('register', [App\Http\Controllers\UserController::class, 'store'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
