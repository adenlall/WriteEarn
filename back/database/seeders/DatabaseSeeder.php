<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Post;
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
        $publishers = User::factory()->publisher()->count(10)->create();
        $readers = User::factory()->reader()->count(10)->create();

        User::factory()->admin()->count(5)->create();

        $publishers->each(function ($publisher) use ($readers) {

            $blogs = Blog::factory()->count(2)->create([
                'user_id' => $publisher->id,
            ]);

            $blogs->each(function ($blog) use ($readers) {

                Post::factory()->count(5)->create([
                    'blog_id' => $blog->id,
                ]);

                $plans = SubscriptionPlan::factory()->count(2)->create([
                    'blog_id' => $blog->id,
                ]);

                $plans->each(function ($plan) use ($readers) {

                    if (rand(0, 1)) {
                        Offer::factory()->create([
                            'subscription_plan_id' => $plan->id,
                        ]);
                    }

                    for ($i = 0; $i < 5; $i++) {
                        $reader = $readers->random();
                        $subscription = ReaderSubscription::factory()->create([
                            'user_id' => $reader->id,
                            'subscription_plan_id' => $plan->id,
                        ]);
                        Payment::factory()->create([
                            'reader_subscription_id' => $subscription->id,
                        ]);
                    }

                });
            });
        });

    }
}
