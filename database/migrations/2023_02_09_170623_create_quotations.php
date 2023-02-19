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
        Schema::create('quotations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_number')->nullable();
            $table->string('customer')->nullable()->required();
            $table->string('vehicle_registration')->nullable()->required();
            $table->string('insu_company_name')->nullable()->required();
            $table->string('brand')->nullable()->required();
            $table->string('car_type')->nullable()->required();
            $table->string('model')->nullable()->required();
            $table->string('car_year')->nullable()->required();
            $table->string('number_items')->nullable();
            $table->string('price')->nullable();
            $table->string('repair_code')->nullable();
            $table->string('claim_number')->nullable();
            $table->string('accident_number')->nullable();
            $table->string('accident_date')->nullable();
            $table->string('repair_date')->nullable();
            $table->string('quotation_date')->nullable();
            $table->string('number')->nullable();
            $table->string('spare_code')->nullable();
            $table->string('list_damaged_parts')->nullable();
            $table->string('quantity')->nullable();
            $table->string('garage')->nullable();
            $table->string('sks')->nullable();
            $table->string('wchp')->nullable();
            $table->string('store')->nullable();
            $table->string('spare_value')->nullable();
            $table->string('including_spare_parts')->nullable();
            $table->string('total_wage')->nullable();
            $table->string('order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quotations');

    }
};
