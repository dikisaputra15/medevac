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
        Schema::create('aircharters', function (Blueprint $table) {
            $table->id();
            $table->string('charter_company_name')->nullable();
            $table->string('aircraft_fixed_wing')->nullable();
            $table->string('aircraft_rotary')->nullable();
            $table->string('service_passenger')->nullable();
            $table->string('service_cargo')->nullable();
            $table->string('other_info_notes')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircharters');
    }
};
