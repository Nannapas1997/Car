<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReceive extends Model
{
    use HasFactory;
    protected $fillable = [
        'choose_garage',
        'job_number',
        'job_number(new_customer)',
        'receive_date',
        'timex',
        'customer',
        'repairman',
        'tel_number',
        'pickup_date',
        'vehicle_registration',
        'brand',
        'model',
        'car_type',
        'mile_number',
        'repair_code',
        'options',
        'insu_company_name',
        'policy_number',
        'noti_number',
        'claim_number',
        'park_type',
        'car_park',
        'content',
        'group_document',
        'real_claim',
        'copy_claim',
        'copy_driver_license',
        'copy_vehicle_regis',
        'copy_policy',
        'power_of_attorney',
        'copy_of_director_id_card',
        'copy_of_person',
        'account_book',
        'atm_card',
        'group_car',
        'front',
        'left',
        'right',
        'back',
        'inside_left',
        'inside_right',
        'inside_truck',
        'etc'
    ];
    // turn off both
public $timestamps = false;

// turn off only updated_at
const UPDATED_AT = false;
}
