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
            $table->string('name')->nullable();
            $table->string('classification_hospital')->nullable();
            $table->string('province')->nullable();
            $table->string('region')->nullable();
            $table->string('facility_level')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->nullable();
            $table->string('house_of_operations')->nullable();
            $table->string('emergency_services')->nullable();
            $table->string('outpatient_services_general')->nullable();
            $table->string('inpatient_services_general')->nullable();
            $table->string('number_of_beds')->nullable();
            $table->string('population_catchment')->nullable();
            $table->string('ownership')->nullable();
            $table->text('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('nearest_accommodations')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->string('inpatient_services')->nullable();
            $table->string('outpatient_services')->nullable();
            $table->string('hr_ER_services')->nullable();
            $table->string('ambulance')->nullable();
            $table->string('helipad')->nullable();
            $table->string('icu')->nullable();
            $table->string('medical')->nullable();
            $table->string('pediatric')->nullable();
            $table->string('dental')->nullable();
            $table->string('optical')->nullable();
            $table->string('ioc')->nullable();
            $table->string('laboratory')->nullable();
            $table->string('pharmacy')->nullable();
            $table->string('medical_imaging')->nullable();
            $table->string('medical_student_training')->nullable();
            $table->string('doctors')->nullable();
            $table->string('nurses')->nullable();
            $table->string('dental_therapist')->nullable();
            $table->string('laboratory_assitent')->nullable();
            $table->string('community_health_workers')->nullable();
            $table->string('health_inspectors')->nullable();
            $table->string('malaria_control_officers')->nullable();
            $table->string('health_extension_officers')->nullable();
            $table->string('casuals')->nullable();
            $table->string('others')->nullable();
            $table->string('nearest_airport')->nullable();
            $table->string('distance_with_airport')->nullable();
            $table->string('get_direction_airport')->nullable();
            $table->string('local_travel_support')->nullable();
            $table->string('nearest_police_station')->nullable();
            $table->string('distance_with_police_station')->nullable();
            $table->string('get_direction_police_station')->nullable();
            $table->string('address_police_station')->nullable();
            $table->string('phone_police_station')->nullable();
            $table->string('hours_of_operation_police')->nullable();
            $table->text('medical_support_websites')->nullable();
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
        Schema::dropIfExists('hospitals');
    }
};
