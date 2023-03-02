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
            $table->string('accident_date', 20)->nullable();
            $table->string('repair_date', 20)->nullable();
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
            $table->dropColumn('accident_date');
            $table->dropColumn('repair_date');
        });
    }
};
