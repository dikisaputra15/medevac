<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Navigationaidairport>
 */
class NavigationaidairportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82, // pastikan model Airport punya factory
            'code' => strtoupper($this->faker->lexify('???')),
            'type' => $this->faker->randomElement(['VOR', 'NDB', 'VOR/DME', 'ILS']),
            'frequency' => $this->faker->randomFloat(2, 108.00, 117.95) . ' MHz',
            'chanel' => 'CH' . rand(1, 99),
            'usage' => $this->faker->randomElement(['enroute', 'terminal', 'approach']),
            'radio_class' => $this->faker->randomElement(['Class A', 'Class B', 'Class C']),
            'power' => $this->faker->numberBetween(5, 500) . ' W',
            'range' => $this->faker->numberBetween(20, 200) . ' NM',
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'elevation' => $this->faker->numberBetween(0, 10000) . ' ft',
            'magnetic_variation' => $this->faker->randomElement(['E', 'W']) . ' ' . rand(1, 15),
            'world_area_code' => strval($this->faker->numberBetween(301, 999)),
            'associated_airport' => strtoupper($this->faker->lexify('???')) . rand(100, 999),
        ];
    }
}
