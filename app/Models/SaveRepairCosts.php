<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveRepairCosts extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'customer',
        'vehicle_registration',
        'brand',
        'model',
        'car_year',
        'expense_item',
        'wage',
        'expense_not_receipt',
        'total'
    ];
    public $timestamps = false;

// turn off only updated_at
const UPDATED_AT = false;
}
