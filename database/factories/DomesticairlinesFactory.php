<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domesticairlines>
 */
class DomesticairlinesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82, // sesuaikan dengan jumlah airport yang ada
            'destination_airport' => $this->faker->city . ' Airport',
            'airlines' => implode(', ', $this->faker->randomElements(
                [$this->faker->company, $this->faker->company, $this->faker->company], rand(2, 3)
            )),
        ];
    }
}
