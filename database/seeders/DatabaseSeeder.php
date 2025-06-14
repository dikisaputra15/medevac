<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            AirportsSeeder::class,
            HospitalSeeder::class,
            EmbassieesSeeder::class,
            NearestairportsSeeder::class,
            InternationalairlinesSeeder::class,
            DomesticairlinesSeeder::class,
            AirportcommunicationSeeder::class,
            NavigationnearbyairportSeeder::class,
            NavigationaidairportSeeder::class,
            RunawayairportSeeder::class,
            AircharterSeeder::class,
            ProvincesregionSeeder::class,
        ]);
    }
}
