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
        Schema::create('save_repair_costs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number_control')->nullable();
            $table->string('customer')->required();
            $table->string('vehicle_registration')->required();
            $table->string('brand')->required();
            $table->string('model')->required();
            $table->string('car_year')->nullable()->required();
            $table->string('wage')->nullable()->required();
            $table->string('expense_not_receipt')->nullable()->required();
            $table->string('total')->nullable()->required();
            $table->string('code_c0_c7')->nullable();
            $table->string('price')->nullable();
            $table->string('spare_code')->nullable();
            $table->string('spare_cost')->nullable();
            $table->string('store')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_repair_costs');
    }
};
