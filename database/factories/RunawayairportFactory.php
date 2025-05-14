<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Runawayairport>
 */
class RunawayairportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82, // Pastikan model Airport sudah punya factory
            'runway_edge_light' => $this->faker->randomElement(['Yes', 'No']),
            'runway_enidentifier_light' => $this->faker->randomElement(['Yes', 'No']),
            'runway' => $this->faker->randomElement(['09/27', '13/31', '04/22']),
            'dimension' => $this->faker->randomElement(['3000 x 45 m', '2500 x 60 m', '2000 x 30 m']),
            'surface' => $this->faker->randomElement(['Asphalt', 'Concrete', 'Grass']),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'elevation' => $this->faker->numberBetween(0, 10000) . ' ft',
            'true_heading' => $this->faker->numberBetween(0, 360),
        ];
    }
}
