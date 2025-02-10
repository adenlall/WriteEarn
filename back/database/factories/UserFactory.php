<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'               => $this->faker->name,
            'username'           => $this->faker->numerify('user-###############'),
            'email'              => $this->faker->unique()->safeEmail,
            'email_verified_at'  => now(),
            'password'           => Hash::make('password'),
            'role'               => 'reader',
            'stripe_customer_id' => $this->faker->optional()->word,
            'stripe_account_id'  => $this->faker->optional()->word,
            'remember_token'     => Str::random(10),
        ];
    }

    public function publisher(): Factory|UserFactory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'publisher',
        ]);
    }

    public function reader(): Factory|UserFactory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'reader',
        ]);
    }

    public function admin(): Factory|UserFactory
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
