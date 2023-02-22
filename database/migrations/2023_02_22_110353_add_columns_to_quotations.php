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
        Schema::table('quotations', function (Blueprint $table) {
            
            $table->string('creation_date')->nullable();
            $table->string('wage')->nullable();
            $table->string('vat')->nullable();
            $table->string('overall')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn('creation_date');
            $table->dropColumn('wage');
            $table->dropColumn('vat');
            $table->dropColumn('overall');
            $table->dropColumn('status');
        });
    }
};
