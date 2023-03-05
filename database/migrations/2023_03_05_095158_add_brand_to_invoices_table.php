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
            $table->string('brand', 20)->nullable();
            $table->string('job_number', 50)->nullable()->change();
            $table->string('customer', 100)->nullable()->change();
            $table->string('invoice_number', 50)->nullable()->change();
            $table->string('good_code', 20)->nullable()->change();
            $table->string('vehicle_registration', 50)->nullable()->change();
            $table->string('invoice_number', 50)->nullable()->change();
            $table->string('amount', 10)->nullable()->change();
            $table->string('vat', 10)->nullable()->change();
            $table->string('aggregate', 10)->nullable()->change();
            $table->string('courier_document', 100)->nullable()->change();
            $table->string('recipient_document', 100)->nullable()->change();
            $table->string('choose_vat_or_not', 20)->nullable()->change();
            $table->string('choose_garage', 10)->nullable()->change();
            $table->string('insu_company_name', 100)->nullable()->change();
            $table->string('biller', 100)->nullable()->change();
            $table->string('bill_payer', 100)->nullable()->change();
            $table->dropColumn('items');
            $table->dropColumn('INV_number');
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
            $table->dropColumn('brand');
            $table->string('items', 50)->nullable()->change();
            $table->string('INV_number', 10)->nullable()->change();
        });
    }
};
