<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aircharter>
 */
class AircharterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       return [
            'charter_company_name' => $this->faker->company . ' Air Charter',
            'aircraft_fixed_wing' => $this->faker->randomElement(['Cessna 208', 'Beechcraft King Air', 'Pilatus PC-12']),
            'aircraft_rotary' => $this->faker->randomElement(['Bell 206', 'Eurocopter AS350', 'Robinson R44']),
            'service_passenger' => $this->faker->randomElement(['Yes', 'No']),
            'service_cargo' => $this->faker->randomElement(['Yes', 'No']),
            'other_info_notes' => $this->faker->sentence(8),
            'icon' =>$this->faker->randomElement([
                'https://c0.klipartz.com/pngpicture/408/311/gratis-png-aeropuerto-internacional-jacksons-puerto-moresby-buka-aeropuerto-aerolinea-niugini-787-logo.png',
                'https://png.pngtree.com/png-vector/20190411/ourmid/pngtree-vector-air-blow-icon-png-image_925352.jpg',
                'https://gimgs2.nohat.cc/thumb/f/350/helicopter-clipart-emergency-helicopter-medical-helicopter-icon--m2H7G6d3m2m2H7Z5.jpg',
                'https://seeklogo.com/images/T/tropic-air-logo-CCEFD60D82-seeklogo.com.png',
                'https://i.tracxn.com/logo/company/deugro_Logo_b50e3f13-189b-48e9-9909-26081633d6ca.jpg',
            ]),
        ];
    }
}
