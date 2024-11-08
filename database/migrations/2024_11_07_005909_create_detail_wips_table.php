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
        Schema::connection('mysql_production')->create('detail_wips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('master_wips_id');
            $table->foreign('master_wips_id')->references('id')->on('master_wips')->onDelete('cascade');
            $table->unsignedBigInteger('qty');
            $table->unsignedBigInteger('acm');
            $table->unsignedBigInteger('balance');
            $table->string('no_hu');
            $table->string('remarks');
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
        Schema::dropIfExists('detail_wips');
    }
};
