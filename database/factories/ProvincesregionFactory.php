<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provincesregion>
 */
class ProvincesregionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
                'provinces_region' => $this->faker->randomElement([
                'Bougainville, Islands Region',
                'Eastern Highlands, Highlands Region',
                'Jiwaka, Highlands Region',
                'Morobe, Momase Region',
                'Simbu (Chimbu), Highlands Region',
                'Western (Fly), Southern Region',
                'Central, Southern Region',
                'Enga, Highlands Region',
                'Madang, Momase Region',
                'New Ireland, Islands Region',
                'Southern Highlands, Highlands Region',
                'Western Highlands, Highlands Region',
                'East New Britain, Islands Region',
                'Gulf, Southern Region',
                'Manus, Islands Region',
                'Northern (Oro), Southern Region',
                'West New Britain, Islands Region',
                'East Sepik, Momase Region',
                'Hela, Highlands Region',
                'Milne Bay, Southern Region',
                'Port Moresby, Southern Region',
                'West Sepik (Sandaun), Momase Region'
            ]),
        ];
    }
}
