<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarRelease extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'job_number',
        'vehicle_registration',
        'save_repair_cost_id',
        'code_c0_c7',
        'price',
        'spare_code',
        'staff_name',
        'staff_position',
        'brand',
        'garage',
        'insu_company_name',
        'policy_number',
        'claim_number',
        'choose_garage',
        'oc_number'

    ];

    const UPDATED_AT = null;
    const CREATED_AT = null;
}
