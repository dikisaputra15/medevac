<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nearestairports>
 */
class NearestairportsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82,
            'name' => $this->faker->city . ' Airport',
            'id_airport' => strtoupper($this->faker->lexify('??') . $this->faker->numerify('###')), // contoh ID tiruan
            'heading' => $this->faker->randomFloat(2, 0, 360) . '°',
            'distance_km' => $this->faker->randomFloat(2, 1, 300) . ' km',
        ];
    }
}
