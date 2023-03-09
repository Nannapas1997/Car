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
        Schema::table('car_releases', function (Blueprint $table) {
            $table->string('car_releaser')->nullable();
            $table->string('real_claim')->nullable();
            $table->string('copy_claim')->nullable();
            $table->string('copy_driver_license')->nullable();
            $table->string('copy_vehicle_regis')->nullable();
            $table->string('copy_policy')->nullable();
            $table->string('power_of_attorney')->nullable();
            $table->string('copy_of_director_id_card')->nullable();
            $table->string('copy_of_person')->nullable();
            $table->string('account_book')->nullable();
            $table->string('atm_card')->nullable();
            $table->string('real_claim_document')->nullable();
            $table->string('copy_policy_document')->nullable();
            $table->string('copy_claim_document')->nullable();
            $table->string('power_of_attorney_document')->nullable();
            $table->string('copy_driver_license_document')->nullable();
            $table->string('copy_of_director_id_card_document')->nullable();
            $table->string('copy_vehicle_regis_document')->nullable();
            $table->string('copy_of_person_document')->nullable();
            $table->string('account_book_document')->nullable();
            $table->string('atm_card_document')->nullable();
            $table->string('cassie_number_document')->nullable();
            $table->string('cassie_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_releases', function (Blueprint $table) {
            $table->dropColumn('car_releaser');
            $table->dropColumn('real_claim');
            $table->dropColumn('copy_claim');
            $table->dropColumn('copy_driver_license');
            $table->dropColumn('copy_vehicle_regis');
            $table->dropColumn('copy_policy');
            $table->dropColumn('power_of_attorney');
            $table->dropColumn('copy_of_director_id_card');
            $table->dropColumn('copy_of_person');
            $table->dropColumn('account_book');
            $table->dropColumn('atm_card');
            $table->dropColumn('real_claim_document');
            $table->dropColumn('copy_policy_document');
            $table->dropColumn('copy_claim_document');
            $table->dropColumn('power_of_attorney_document');
            $table->dropColumn('copy_driver_license_document');
            $table->dropColumn('copy_of_director_id_card_document');
            $table->dropColumn('copy_vehicle_regis_document');
            $table->dropColumn('copy_of_person_document');
            $table->dropColumn('account_book_document');
            $table->dropColumn('atm_card_document');
            $table->dropColumn('cassie_number_document');
            $table->dropColumn('cassie_number');
        });
    }
};
