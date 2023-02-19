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
            $table->bigIncrements('id');
            $table->string('job_number');
            $table->string('vehicle_registration');
            $table->string('staff_name')->nullable();
            $table->string('staff_position')->nullable();
            $table->string('brand')->nullable();
            $table->string('choose_garage')->nullable();
            $table->string('insu_company_name')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('claim_number')->nullable();
            $table->softDeletes();
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
