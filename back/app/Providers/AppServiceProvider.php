<?php

namespace App\Providers;

use App\Models\Blog;
use App\Models\User;
use App\Policies\BlogPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
