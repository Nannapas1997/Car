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
        Schema::table('price_control_bills', function (Blueprint $table) {
            $table->string('labor_price')->nullable();
            $table->string('price_offer')->nullable();
            $table->string('wage_stop')->nullable();
            $table->string('price_spare_parts')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('price_control_bills', function (Blueprint $table) {
            $table->dropColumn('labor_price');
            $table->dropColumn('price_offer');
            $table->dropColumn('wage_stop');
            $table->dropColumn('price_spare_parts');
        });
    }
};
