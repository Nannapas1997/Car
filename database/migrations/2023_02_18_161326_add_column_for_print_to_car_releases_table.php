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
        Schema::table('car_releases', function (Blueprint $table) {
            $table->bigIncrements('id')->first();
            $table->string('staff_name');
            $table->string('staff_position');
            $table->string('car_brand');
            $table->string('garage');
            $table->string('insurance_name');
            $table->string('policy_number');
            $table->string('claim_number');
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
        Schema::table('car_releases', function (Blueprint $table) {
            $table->dropColumn('id');
            $table->dropColumn('staff_name');
            $table->dropColumn('staff_position');
            $table->dropColumn('car_brand');
            $table->dropColumn('garage');
            $table->dropColumn('insurance_name');
            $table->dropColumn('policy_number');
            $table->dropColumn('claim_number');
            $table->dropSoftDeletes();
        });
    }
};
