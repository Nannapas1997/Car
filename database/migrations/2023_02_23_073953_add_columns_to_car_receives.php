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
        Schema::table('car_receives', function (Blueprint $table) {
            $table->string('customer_tel_number')->nullable();
            $table->string('driver_tel_number')->nullable();
            $table->string('repairman_tel_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_receives', function (Blueprint $table) {
            $table->dropColumn('customer_tel_number');
            $table->dropColumn('driver_tel_number');
            $table->dropColumn('repairman_tel_number');
        });
    }
};
