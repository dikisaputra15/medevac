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
        Schema::create('nearestairports', function (Blueprint $table) {
            $table->id();
            $table->integer('airport_id');
            $table->string('name')->nullable();
            $table->string('id_airport')->nullable();
            $table->string('heading')->nullable();
            $table->string('distance_km')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nearestairports');
    }
};
