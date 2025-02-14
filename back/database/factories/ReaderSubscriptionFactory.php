<?php /** @noinspection PhpDocMissingThrowsInspection */

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
        $start_date = $this->faker->dateTimeBetween('-1 year');
        /** @noinspection PhpUnhandledExceptionInspection */
        $end_date = (clone $start_date)->modify('+30 days');

        $plan = SubscriptionPlan::factory()->create();

        return [
            'user_id' => User::factory()->reader(),
            'subscription_plan_id' => $plan->id,
            'blog_id' => $plan->blog->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $this->faker->randomElement(['active', 'canceled']),
        ];
    }
}
