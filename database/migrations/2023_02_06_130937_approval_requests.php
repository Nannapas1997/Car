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
            $table->string('job_number')->nullable();
            $table->string('approval_number')->required();
            $table->string('vehicle_registration')->required();
            $table->string('notification_number')->required();
            $table->string('number_ab')->required();
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
