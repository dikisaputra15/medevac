<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Airportcommunication>
 */
class AirportcommunicationFactory extends Factory
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
            'tower' => $this->faker->randomElement(['Tower A', 'Tower B', 'Main Tower']),
            'frequensi' => $this->faker->randomElement(['118.1 MHz', '120.5 MHz', '123.9 MHz']),
        ];
    }
}
