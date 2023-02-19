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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_number')->nullable();
            $table->string('vehicle_registration')->nullable()->required();
            $table->string('input')->nullable();
            $table->string('pickup_time')->nullable();
            $table->string('picking_list')->nullable()->required();
            $table->string('spare_code')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('forerunner')->nullable();
            $table->string('approver')->nullable();
            $table->string('parts_list')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
};
