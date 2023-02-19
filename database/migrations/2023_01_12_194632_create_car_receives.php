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
        Schema::create('car_receives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('choose_garage')->required();
            $table->string('job_number');
            $table->date('receive_date')->nullable();
            $table->time('timex')->nullable()->required();
            $table->string('customer')->nullable()->required();
            $table->string('repairman')->nullable()->required();
            $table->string('tel_number')->nullable()->required();
            $table->date('pickup_date')->nullable();
            $table->string('vehicle_registration')->nullable();
            $table->string('brand')->nullable()->required();
            $table->string('model')->nullable()->required();
            $table->string('car_type')->nullable()->required();
            $table->string('mile_number')->nullable()->required();
            $table->string('repair_code')->nullable()->required();
            $table->string('options')->nullable()->required();
            $table->string('insu_company_name')->nullable()->required();
            $table->string('policy_number')->nullable()->require();
            $table->string('noti_number')->nullable()->required();
            $table->string('claim_number')->nullable()->required();
            $table->string('park_type')->nullable()->required();
            $table->string('content')->nullable()->required();
            $table->date('car_park')->nullable()->required();
            $table->string('group_document')->nullable();
            $table->string('real_claim')->required()->nullable();
            $table->string('copy_claim')->required()->nullable();
            $table->string('copy_driver_license')->required()->nullable();
            $table->string('copy_vehicle_regis')->required()->nullable();
            $table->string('copy_policy')->required()->nullable();
            $table->string('power_of_attorney')->required()->nullable();
            $table->string('copy_of_director_id_card')->required()->nullable();
            $table->string('copy_of_person')->required()->nullable();
            $table->string('account_book')->required()->nullable();
            $table->string('atm_card')->required()->nullable();
            $table->string('group_checkbox')->nullable();
            $table->boolean('spare_tire')->nullable();
            $table->boolean('jack_handle')->nullable();
            $table->boolean('boxset')->nullable();
            $table->boolean('batteries')->nullable();
            $table->boolean('cigarette_lighter')->nullable();
            $table->boolean('radio')->nullable();
            $table->boolean('floor_mat')->nullable();
            $table->boolean('spare_removal')->nullable();
            $table->boolean('fire_extinguisher')->nullable();
            $table->boolean('spining_wheel')->nullable();;
            $table->boolean('other')->nullable();
            $table->string('customer_document')->nullable();
            $table->boolean('real_claim_document')->nullable();
            $table->boolean('copy_policy_document')->nullable();
            $table->boolean('copy_claim_document')->nullable();
            $table->boolean('power_of_attorney_document')->nullable();
            $table->boolean('copy_driver_license_document')->nullable();
            $table->boolean('copy_of_director_id_card_document')->nullable();
            $table->boolean('copy_vehicle_regis_document')->nullable();
            $table->boolean('copy_of_person_document')->nullable();
            $table->boolean('account_book_document')->nullable();
            $table->boolean('atm_card_document')->nullable();
            $table->boolean('other_document')->nullable();
            $table->string('group_car')->nullable();
            $table->string('front')->required()->nullable();
            $table->string('left')->required()->nullable();
            $table->string('right')->required()->nullable();
            $table->string('back')->required()->nullable();
            $table->string('inside_left')->required()->nullable();
            $table->string('inside_right')->required()->nullable();
            $table->string('inside_truck')->required()->nullable();
            $table->string('etc')->required()->nullable();
            $table->string('addressee')->nullable();
            $table->string('car_year')->nullable();
            $table->string('deleted_at')->nullable();
            $table->string('created_at')->nullable();
            $table->string('car_accident')->nullable();
            $table->string('car_accident_choose')->nullable();
            $table->string('options-car')->nullable();
            $table->string('content_other')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->string('amphoe')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_receives');
    }
};
