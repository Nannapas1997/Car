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
            $table->string('number_price_control')->nullable()->required();
            $table->string('number_ab')->nullable()->required();
            $table->string('customer')->nullable()->required();
            $table->string('vehicle_registration')->nullable()->required();
            $table->string('insu_company_name')->nullable()->required();
            $table->string('termination_price')->nullable()->required();
            $table->string('note')->nullable()->required();
            $table->string('courier')->nullable()->required();
            $table->string('price_dealer')->nullable()->required();
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
