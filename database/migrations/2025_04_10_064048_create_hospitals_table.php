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
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('province');
            $table->string('region');
            $table->string('facility_level');
            $table->string('address');
            $table->string('status');
            $table->string('house_of_operations');
            $table->string('emergency_services');
            $table->string('outpatient_services_general');
            $table->string('inpatient_services_general');
            $table->string('number_of_beds');
            $table->string('population_catchment');
            $table->string('ownership');
            $table->text('telephone');
            $table->string('email');
            $table->string('website');
            $table->text('nearest_accommodations');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('inpatient_services');
            $table->string('outpatient_services');
            $table->string('hr_ER_services');
            $table->string('ambulance');
            $table->string('helipad');
            $table->string('icu');
            $table->string('medical');
            $table->string('pediatric');
            $table->string('dental');
            $table->string('optical');
            $table->string('ioc');
            $table->string('laboratory');
            $table->string('pharmacy');
            $table->string('medical_imaging');
            $table->string('medical_student_training');
            $table->string('doctors');
            $table->string('nurses');
            $table->string('dental_therapist');
            $table->string('laboratory_assitent');
            $table->string('community_health_workers');
            $table->string('health_inspectors');
            $table->string('malaria_control_officers');
            $table->string('health_extension_officers');
            $table->string('casuals');
            $table->string('others');
            $table->string('nearest_airport');
            $table->string('distance_with_airport');
            $table->string('get_direction_airport');
            $table->string('local_travel_support');
            $table->string('nearest_police_station');
            $table->string('distance_with_police_station');
            $table->string('get_direction_police_station');
            $table->string('address_police_station');
            $table->string('phone_police_station');
            $table->string('hours_of_operation_police');
            $table->text('medical_support_websites');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
