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
        Schema::create('navigationnearbyairports', function (Blueprint $table) {
            $table->id();
            $table->integer('airport_id');
            $table->string('dist_nm')->nullable();
            $table->string('name_id_airport')->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('freq_mhz')->nullable();
            $table->string('true_hdg')->nullable();
            $table->string('mag_hdg')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigationnearbyairports');
    }
};
