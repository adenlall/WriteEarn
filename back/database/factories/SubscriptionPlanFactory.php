<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SubscriptionPlan>
 */
class SubscriptionPlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_id'   => Blog::factory(),
            'price'     => $this->faker->randomFloat(2, 5, 100),
            'duration'  => $this->faker->randomElement(['monthly', 'yearly', 'weekly']),
            'discount'  => $this->faker->boolean() ? $this->faker->randomFloat(2, 5, 50) : null,
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
