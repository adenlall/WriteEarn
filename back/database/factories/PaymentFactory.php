<?php

namespace Database\Factories;

use App\Models\ReaderSubscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount            = $this->faker->randomFloat(2, 5, 100);
        $platform_fee      = round($amount * 0.1, 2);
        $publisher_earning = round($amount - $platform_fee, 2);
        return [
            'subscription_id'   => ReaderSubscription::factory(),
            'amount'            => $amount,
            'platform_fee'      => $platform_fee,
            'publisher_earning' => $publisher_earning,
            'status'            => $this->faker->randomElement(['success', 'failed']),
        ];
    }
}
