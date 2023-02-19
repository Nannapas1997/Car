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
        Schema::create('cash_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('disbursement_amount')->nullable();
            $table->string('buy_consumables')->nullable()->required();
            $table->string('buy_spare')->nullable();
            $table->string('oil')->nullable();
            $table->string('common_expenses')->nullable();
            $table->string('transportation_cost')->nullable();
            $table->string('customer_testimonials')->nullable();
            $table->string('insurance_certification')->nullable();
            $table->string('internal_certification_fee')->nullable();
            $table->string('financial')->nullable();
            $table->string('forerunner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_receipts');
    }
};
