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
            $table->string('staff_name')->nullable();
            $table->string('staff_position')->nullable();
            $table->string('brand')->nullable();
            $table->string('choose_garage')->nullable();
            $table->string('insu_company_name')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('claim_number')->nullable();
            $table->string('code_c0_c7')->nullable();
            $table->string('price')->nullable();
            $table->string('spare_code')->nullable();
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
            $table->dropColumn('brand');
            $table->dropColumn('choose_garage');
            $table->dropColumn('insu_company_name');
            $table->dropColumn('policy_number');
            $table->dropColumn('claim_number');
            $table->dropColumn('code_c0_c7');
            $table->dropColumn('price');
            $table->dropColumn('spare_code');
            $table->dropSoftDeletes();
        });
    }
};
