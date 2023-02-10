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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->nullable();
            $table->foreignId('purchase_orders.purchase_order_id');
            $table->string('vehicle_registration')->nullable()->required();
            $table->string('model')->required();
            $table->string('car_year')->nullable()->required();
            $table->string('store')->nullable()->required();
            $table->string('parts_list_total')->nullable()->required();
            $table->string('parts_list')->nullable()->required();
            $table->string('spare_code')->nullable()->required();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->string('aggregate_price')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('purchase_orders');
    }
};
