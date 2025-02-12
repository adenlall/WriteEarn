<?php

namespace Database\Factories;

use App\Models\ReaderSubscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReaderSubscription>
 */
class ReaderSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeBetween('-1 year', 'now');
        $end_date = (clone $start_date)->modify('+30 days');

        return [
            'user_id' => User::factory()->reader(),
            'subscription_plan_id' => SubscriptionPlan::factory(),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $this->faker->randomElement(['active', 'canceled']),
        ];
    }
}
