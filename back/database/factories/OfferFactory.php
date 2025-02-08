<?php

namespace Database\Factories;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeBetween('-1 month', 'now');
        $end_date   = (clone $start_date)->modify('+' . $this->faker->numberBetween(1, 30) . ' days');

        return [
            'coupon'    => $this->faker->lexify(),
            'plan_id'   => SubscriptionPlan::factory(),
            'discount'  => $this->faker->randomFloat(2, 5, 50),
            'start_date'=> $start_date,
            'end_date'  => $end_date,
        ];
    }
}
