<?php

namespace App\Models;

use App\Models\QuotationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'customer',
        'vehicle_registration',
        'insu_company_name',
        'brand',
        'car_type',
        'model',
        'car_year',
        'number_items',
        'price',
        'claim_number',
        'accident_number',
        'accident_date',
        'repair_date',
        'quotation_date',
        'number',
        'spare_code',
        'list_damaged_parts',
        'quantity',
        'garage',
        'sks',
        'wchp',
        'store',
        'spare_value',
        'including_spare_parts',
        'total_wage',
    ];
    public $timestamps = false;
    // turn off only updated_at
        const UPDATED_AT = false;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function quotationitem():HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }
}
