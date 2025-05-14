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
        Schema::create('navigationaidairports', function (Blueprint $table) {
            $table->id();
            $table->integer('airport_id');
            $table->string('code')->nullable();
            $table->string('type')->nullable();
            $table->string('frequency')->nullable();
            $table->string('chanel')->nullable();
            $table->string('usage')->nullable();
            $table->string('radio_class')->nullable();
            $table->string('power')->nullable();
            $table->string('range')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('elevation')->nullable();
            $table->string('magnetic_variation')->nullable();
            $table->string('world_area_code')->nullable();
            $table->string('associated_airport')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigationaidairports');
    }
};
