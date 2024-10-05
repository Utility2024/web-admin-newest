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
        Schema::connection('mysql_wh')->create('tray_ins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tray_stock_id');
            $table->unsignedBigInteger('master_racks_id');
            $table->integer('qty');
            $table->timestamps();
            $table->foreign('tray_stock_id')->references('id')->on('tray_stocks')->onDelete('cascade');
            $table->foreign('master_racks_id')->references('id')->on('master_racks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tray_ins');
    }
};
