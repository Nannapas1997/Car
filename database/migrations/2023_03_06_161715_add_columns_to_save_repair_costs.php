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
            $table->string('courier_document')->nullable();
            $table->string('approver')->nullable();
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
            $table->dropColumn('courier_document');
            $table->dropColumn('approver');
        });
    }
};
