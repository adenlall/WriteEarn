<?php

use App\Http\Controllers\AuthController;
use App\Models\ReaderSubscription;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(ReaderSubscription::create([
        'user_id' => 1,
        'subscription_plan_id' => 1,
        'blog_id' => 1,
        'status' => 'active',
        'start_date' => now(),
        'end_date' => now()->addDays(30),
    ]));

    return view('welcome');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'users' => App\Http\Controllers\UserController::class,
        'blogs' => App\Http\Controllers\BlogController::class,
    ]);
    Route::apiResource('blogs.posts', App\Http\Controllers\PostController::class)
        ->scoped([
            'posts' => 'user_id',
        ]);

    Route::apiResource('blogs.plans', App\Http\Controllers\SubscriptionPlanController::class)
        ->parameters(['plans' => 'subscription_plan'])
        ->scoped([
            'plans' => 'blog_id',
        ]);

    Route::apiResource('blogs.plans.offers', App\Http\Controllers\OfferController::class)
        ->parameters(['plans' => 'subscription_plan'])
        ->scoped([
            'plans' => 'blog_id',
        ]);

    Route::apiResource('users.subs', App\Http\Controllers\ReaderSubscriptionController::class)
        ->parameters(['subs' => 'reader_subscription'])
        ->scoped([
            'subs' => 'user_id',
        ]);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('auth', [AuthController::class, 'user'])->name('auth');
});

Route::post('register', [App\Http\Controllers\UserController::class, 'store'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
