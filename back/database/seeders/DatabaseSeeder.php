<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\ReaderSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'role' => 'admin',
            'name' => 'adenlall',
            'email' => 'ade@lall.me',
            'password' => Hash::make('0'),
            'username' => 'adenlall',
        ]);

        Blog::factory()
            ->hasPosts()
            ->has(User::factory()->publisher())
            ->has(SubscriptionPlan::factory()->count(3))
            ->count(10)
            ->create();

        ReaderSubscription::factory()->count(50)->create();
    }
}
