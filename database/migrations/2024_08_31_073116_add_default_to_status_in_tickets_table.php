<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Set default value to 'Open'
            $table->string('status')->default('Open')->change();
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Optional: Remove the default value if you want to revert
            $table->string('status')->change();
        });
    }
};
