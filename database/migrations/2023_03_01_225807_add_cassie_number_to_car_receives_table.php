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
            $table->string('cassie_number', 20)->nullable();
            $table->string('job_number', 50)->nullable()->change();
            $table->string('status', 20)->nullable()->change();
            $table->string('tel_number', 20)->nullable()->change();
            $table->string('brand', 100)->nullable()->change();
            $table->string('mile_number', 20)->nullable()->change();
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
            $table->dropColumn('cassie_number');
        });
    }
};
