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
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('job_number')->nullable();
            $table->string('customer')->required();
            $table->string('vehicle_registration')->required();
            $table->string('invoice_number')->required();
            $table->string('bill_number')->nullable()->required();
            $table->string('amount')->nullable()->required();
            $table->string('vat')->nullable()->required();
            $table->string('aggregate')->nullable()->required();
            $table->string('courier_document')->nullable();
            $table->string('recipient_document')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
