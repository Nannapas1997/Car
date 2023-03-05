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
        Schema::table('bills', function (Blueprint $table) {
            $table->string('choose_vat_or_not', 20)->nullable();
            $table->string('job_number', 50)->nullable()->change();
            $table->string('customer', 100)->nullable()->change();
            $table->string('vehicle_registration', 50)->nullable()->change();
            $table->string('invoice_number', 50)->nullable()->change();
            $table->string('bill_number', 20)->nullable()->change();
            $table->string('amount', 10)->nullable()->change();
            $table->string('vat', 10)->nullable()->change();
            $table->string('aggregate', 10)->nullable()->change();
            $table->string('courier_document', 100)->nullable()->change();
            $table->string('recipient_document', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->dropColumn('choose_vat_or_not');
        });
    }
};
