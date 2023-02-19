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
        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->string('approval_number')->nullable()->required();
            $table->string('vehicle_registration')->nullable()->required();
            $table->string('notification_number')->nullable()->required();
            $table->string('number_ab')->nullable()->required();
            $table->string('amount')->nullable()->required();
            $table->string('vat')->nullable()->required();
            $table->string('aggregate')->nullable()->required();
            $table->string('condition_value')->nullable()->required();
            $table->string('insu_company_name')->nullable();
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
        Schema::dropIfExists('approval_requests');
    }
};
