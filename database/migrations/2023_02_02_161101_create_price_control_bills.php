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
        Schema::create('price_control_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_number_control')->nullable();
            $table->string('number_price_control')->required();
            $table->string('notification_number')->required();
            $table->string('number_ab')->required();
            $table->string('customer')->required();
            $table->string('vehicle_registration')->required();
            $table->string('insu_company_name')->required();
            $table->string('termination_price')->required();
            $table->string('note')->required();
            $table->string('courier')->required();
            $table->string('price_dealer')->required();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_control_bills');
    }
};
