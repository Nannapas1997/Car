<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use AlperenErsoy\FilamentExport\FilamentExport;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;

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
            $table->id();
            $table->string('choose_garage')->required();
            $table->string('job_number');
            $table->string('job_number_new');
            $table->date('receive_date')->required();
            $table->time('timex')->required();
            $table->string('customer')->required();
            $table->string('repairman')->required();
            $table->string('tel_number')->required();
            $table->date('pickup_date')->required();
            $table->string('vehicle_registration')->required();
            $table->string('brand')->required();
            $table->string('model')->required();
            $table->string('car_type')->required();
            $table->string('mile_number')->required();
            $table->string('repair_code')->required();
            $table->string('options')->required();
            $table->string('insu_company_name')->required();
            $table->string('policy_number')->require();
            $table->string('noti_number')->required();
            $table->string('claim_number')->required();
            $table->string('park_type')->required();
            $table->string('content')->required();
            $table->date('car_park')->required();
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
            $table->string('addressee')->required();
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
