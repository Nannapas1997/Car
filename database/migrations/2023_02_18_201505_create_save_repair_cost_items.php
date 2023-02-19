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
        Schema::create('save_repair_cost_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vehicle_registration')->nullable();
            $table->foreignId('save_repair_cost_id');
            $table->string('code_c0_c7')->nullable();
            $table->string('price')->nullable();
            $table->string('spare_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('save_repair_cost_items');
    }
};
