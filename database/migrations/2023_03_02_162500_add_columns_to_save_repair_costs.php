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
        Schema::table('save_repair_costs', function (Blueprint $table) {
            $table->string('taxpayer_number')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('tel_number')->nullable();
            $table->string('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('save_repair_costs', function (Blueprint $table) {
            $table->dropColumn('taxpayer_number');
            $table->dropColumn('contact_name');
            $table->dropColumn('tel_number');
            $table->dropColumn('address');
        });
    }
};
