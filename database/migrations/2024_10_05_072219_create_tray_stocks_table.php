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
        Schema::connection('mysql_wh')->create('tray_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('plant_buffer'); // Plant Buffer
            $table->string('material'); // Material
            $table->string('plant'); // Plant
            $table->string('material_description'); // Material Description
            $table->integer('qty'); // Quantity
            $table->string('locator'); // Locator
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tray_stocks');
    }
};