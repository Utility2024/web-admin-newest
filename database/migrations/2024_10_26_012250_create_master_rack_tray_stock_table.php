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
        Schema::connection('mysql_wh')->create('master_rack_tray_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tray_stock_id')->constrained('tray_stocks')->onDelete('cascade');
            $table->foreignId('master_racks_id')->constrained('master_racks')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_rack_tray_stock');
    }
};
