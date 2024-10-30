<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedStatusTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql_utility')->create('led_status', function (Blueprint $table) {
            $table->id();
            $table->enum('led_01', ['ON', 'OFF']);
            $table->enum('led_02', ['ON', 'OFF']);
            $table->enum('led_03', ['ON', 'OFF']);
            $table->enum('led_04', ['ON', 'OFF']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('led_status');
    }
}
