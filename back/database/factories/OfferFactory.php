<?php /** @noinspection PhpDocMissingThrowsInspection */

namespace Database\Factories;

use App\Models\Offer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
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
        $start_date = $this->faker->dateTimeBetween('-1 month');
        /** @noinspection PhpUnhandledExceptionInspection */
        $end_date = (clone $start_date)->modify('+'.$this->faker->numberBetween(1, 30).' days');

        return [
            'coupon' => $this->faker->lexify(),
            'discount' => $this->faker->randomFloat(2, 5, 50),
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
