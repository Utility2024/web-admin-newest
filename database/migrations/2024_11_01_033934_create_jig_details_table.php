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
        Schema::connection('mysql_esd')->create('jig_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jigs_id');
            $table->foreign('jigs_id')->references('id')->on('jigs')->onDelete('cascade');
            $table->string('location');
            $table->unsignedBigInteger('j1');
            $table->string('judgement_j1');
            $table->unsignedBigInteger('j2');
            $table->string('judgement_j2');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jig_details');
    }
};
