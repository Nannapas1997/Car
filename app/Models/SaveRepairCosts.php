<?php

namespace App\Models;

use App\Models\CarReceive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveRepairCosts extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number_control',
        'customer',
        'vehicle_registration',
        'brand',
        'model',
        'car_year',
        'wage',
        'expense_not_receipt',
        'total',
        'code_c0_c7',
        'price',
        'spare_code',
        'spare_cost',
        
    ];
    public $timestamps = false;

// turn off only updated_at
const UPDATED_AT = false;
}
