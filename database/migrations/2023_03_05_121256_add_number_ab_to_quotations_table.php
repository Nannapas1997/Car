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
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('number_ab', 20)->nullable();
            $table->string('choose_garage', 10)->nullable();
            $table->string('job_number', 50)->nullable()->change();
            $table->string('vehicle_registration', 50)->nullable()->change();
            $table->string('vat', 10)->nullable()->change();
            $table->string('choose_vat_or_not', 20)->nullable()->change();
            $table->string('choose_vat_or_not_1', 20)->nullable()->change();
            $table->string('insu_company_name', 100)->nullable()->change();
            $table->string('brand', 20)->nullable()->change();
            $table->string('car_type', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('number_ab');
            $table->dropColumn('choose_garage');
        });
    }
};
