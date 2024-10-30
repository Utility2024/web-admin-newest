<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorDataTable extends Migration
{
    public function up()
    {
        Schema::connection('mysql_utility')->create('sensor_data', function (Blueprint $table) {
            $table->id();// e.g., esp32_01
            $table->float('temperature');
            $table->integer('humidity');
            $table->string('status_read_sensor_dht11');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_data');
    }
}
