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
        Schema::table('employee_histories', function (Blueprint $table) {
            $table->string('postal_code')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('district')->nullable();
            $table->string('amphoe')->nullable();
            $table->string('province')->nullable();
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
        Schema::table('employee_histories', function (Blueprint $table) {
            $table->dropColumn('postal_code');
            $table->dropColumn('zipcode');
            $table->dropColumn('district');
            $table->dropColumn('amphoe');
            $table->dropColumn('province');
            $table->dropColumn('approver');
        });
    }
};
