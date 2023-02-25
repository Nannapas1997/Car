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
        Schema::table('car_receives', function (Blueprint $table) {
            $table->string('id_card_attachment')->nullable();
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_receives', function (Blueprint $table) {
            $table->dropColumn('id_card_attachment');
            $table->dropColumn('updated_at');
        });
    }
};
