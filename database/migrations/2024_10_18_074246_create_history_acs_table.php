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
        Schema::connection('mysql_utility')->create('history_acs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acs_id');
            $table->foreign('acs_id')->references('id')->on('acs')->onDelete('cascade');
            $table->string('equipment_name');
            $table->string('area');
            $table->string('location');
            $table->string('type');
            $table->string('status');
            $table->string('description');
            $table->string('photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_acs');
    }
};
