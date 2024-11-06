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
        Schema::connection('mysql_esd')->create('magazine_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('magazines_id');
            $table->foreign('magazines_id')->references('id')->on('magazines')->onDelete('cascade');
            $table->unsignedBigInteger('m1');
            $table->string('judgement_m1');
            $table->unsignedBigInteger('m2');
            $table->string('judgement_m2');
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
        Schema::dropIfExists('magazine_details');
    }
};
