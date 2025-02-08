<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\ReaderSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $publishers = User::factory()->publisher()->count(10)->create();
        $readers    = User::factory()->reader()->count(50)->create();

        User::factory()->admin()->count(5)->create();

        $publishers->each(function ($publisher) use ($readers) {

            $blogs = Blog::factory()->count(3)->create([
                'publisher_id' => $publisher->id,
            ]);

            $blogs->each(function ($blog) use ($readers) {

                $plans = SubscriptionPlan::factory()->count(2)->create([
                    'blog_id' => $blog->id,
                ]);

                $plans->each(function ($plan) use ($readers) {

                    if (rand(0, 1)) {
                        Offer::factory()->create([
                            'plan_id' => $plan->id,
                        ]);
                    }

                    for ($i = 0; $i < 5; $i++) {
                        $reader = $readers->random();
                        $subscription = ReaderSubscription::factory()->create([
                            'reader_id' => $reader->id,
                            'plan_id'   => $plan->id,
                        ]);
                        Payment::factory()->create([
                            'subscription_id' => $subscription->id,
                        ]);
                    }

                });
            });
        });

    }
}
