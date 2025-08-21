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
        Schema::table('airports', function (Blueprint $table) {
             $table->text('dgoca')->nullable()->after('airport_status');
             $table->text('soao')->nullable()->after('dgoca');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airports', function (Blueprint $table) {
             $table->dropColumn('dgoca');
             $table->dropColumn('soao');
        });
    }
};
