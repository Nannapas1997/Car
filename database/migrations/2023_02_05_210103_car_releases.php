<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_releases', function (Blueprint $table) {
            $table->string('job_number');
            $table->string('vehicle_registration');
            $table->foreignId('save_repair_cost_id');
            $table->string('code_c0_c7');
            $table->string('price');
            $table->string('spare_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_releases');
    }
};
