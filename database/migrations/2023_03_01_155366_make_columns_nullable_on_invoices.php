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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('customer')->nullable()->change();
            $table->string('invoice_number')->nullable()->change();
            $table->string('good_code')->nullable()->change();
            $table->string('vehicle_registration')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('customer')->nullable(false)->change();
            $table->string('invoice_number')->nullable(false)->change();
            $table->string('good_code')->nullable(false)->change();
            $table->string('vehicle_registration')->nullable(false)->change();
        });
    }
};
