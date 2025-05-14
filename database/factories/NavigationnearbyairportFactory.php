<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Navigationnearbyairport>
 */
class NavigationnearbyairportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'airport_id' => 82, // asumsi relasi ke model Airport
            'dist_nm' => $this->faker->randomFloat(2, 5, 100), // nautical miles (nm)
            'name_id_airport' => strtoupper($this->faker->lexify('???')) . rand(100, 999),
            'name' => $this->faker->city . ' Nav',
            'type' => $this->faker->randomElement(['VOR', 'NDB', 'DME', 'VOR/DME']),
            'freq_mhz' => $this->faker->randomFloat(1, 108.0, 117.95) . ' MHz',
            'true_hdg' => $this->faker->randomFloat(1, 0, 360),
            'mag_hdg' => $this->faker->randomFloat(1, 0, 360),
        ];
    }
}
