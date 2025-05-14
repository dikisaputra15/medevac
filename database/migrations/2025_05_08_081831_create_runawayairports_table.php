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
        Schema::create('runawayairports', function (Blueprint $table) {
            $table->id();
            $table->integer('airport_id');
            $table->string('runway_edge_light')->nullable();
            $table->string('runway_enidentifier_light')->nullable();
            $table->string('runway')->nullable();
            $table->string('dimension')->nullable();
            $table->string('surface')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('elevation')->nullable();
            $table->string('true_heading')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('runawayairports');
    }
};
