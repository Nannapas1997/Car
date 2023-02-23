<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PriceControlBills extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number_control',
        'number_price_control',
        'noti_number',
        'number_ab',
        'customer',
        'vehicle_registration',
        'insu_company_name',
        'termination_price',
        'note',
        'courier',
        'price_dealer',
    ];
    public $timestamps = false;
// turn off only updated_at
    const UPDATED_AT = false;
}
