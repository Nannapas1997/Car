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
        Schema::create('employee_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->string('order')->nullable();
            $table->string('employee_lists')->nullable()->required();
            $table->string('disbursement_amount')->nullable()->required();
            $table->string('input')->nullable();
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
        Schema::dropIfExists('employee_requisition_items');
    }
};
