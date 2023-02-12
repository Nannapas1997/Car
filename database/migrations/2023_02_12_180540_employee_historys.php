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
        Schema::create('employee_historys', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->nullable();
            $table->string('employee_lists')->nullable()->required();
            $table->string('prefix')->nullable()->required();
            $table->string('name_surname')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('id_card')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('start_work_date')->nullable();
            $table->string('field')->nullable();
            $table->string('technician_team')->nullable();
            $table->string('under_the_cradle')->nullable();
            $table->string('salary')->nullable();
            $table->string('other_money')->nullable();
            $table->string('employee_termination_date')->nullable();
            $table->string('cause')->nullable();
            $table->string('resignation_document')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_historys');
    }
};
