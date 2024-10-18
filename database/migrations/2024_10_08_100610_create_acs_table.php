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
        Schema::connection('mysql_utility')->create('acs', function (Blueprint $table) {
            $table->id();
            $table->string('area');                // Column for Area
            $table->string('equipment_name');      // Column for Equipment Name
            $table->string('equipment_number');    // Column for Equipment Number
            $table->string('location');            // Column for Location
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acs');
    }
};
