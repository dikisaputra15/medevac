<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->integer('province_id');
            $table->string('airport_name')->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('category')->nullable();
            $table->string('classification')->nullable();
            $table->string('iata_code')->nullable();
            $table->string('icao_code')->nullable();
            $table->string('hrs_of_operation')->nullable();
            $table->text('distance_from')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('operator')->nullable();
            $table->string('magnetic_variation')->nullable();
            $table->string('beacon')->nullable();
            $table->string('max_aircraft_capability')->nullable();
            $table->string('air_traffic')->nullable();
            $table->string('meteorological')->nullable();
            $table->string('air_fuel_depot')->nullable();
            $table->text('supplies_eqipment')->nullable();
            $table->string('internet')->nullable();
            $table->text('public_facilities')->nullable();
            $table->text('public_transportation')->nullable();
            $table->text('other_airport_info')->nullable();
            $table->text('nearest_accommodation')->nullable();
            $table->text('flight_information')->nullable();
            $table->text('nearest_medical_facility')->nullable();
            $table->text('nearest_airport')->nullable();
            $table->string('get_direction_medical_facility')->nullable();
            $table->text('nearest_police_station')->nullable();
            $table->string('address_police_station')->nullable();
            $table->string('phone_police_station')->nullable();
            $table->string('hours_of_operation_police')->nullable();
            $table->string('get_direction_police_station')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
