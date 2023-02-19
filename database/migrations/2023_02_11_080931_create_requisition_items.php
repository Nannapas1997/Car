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
        Schema::create('requisition_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisition_id');
            $table->string('job_number')->nullable();
            $table->string('picking_list')->nullable()->required();
            $table->string('spare_code')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('forerunner')->nullable();
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
        Schema::dropIfExists('requisition_items');
    }
};
