<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internationalairlines>
 */
class InternationalairlinesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82, // Sesuaikan dengan jumlah airport yang ada
            'country' => $this->faker->country,
            'destination_city' => $this->faker->city,
            'airlines' => implode(', ', $this->faker->randomElements(
                [$this->faker->company, $this->faker->company, $this->faker->company], rand(2, 3)
            )),
        ];
    }
}
