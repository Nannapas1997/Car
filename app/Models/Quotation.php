<?php

namespace App\Models;

use App\Models\QuotationItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quotation extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    const UPDATED_AT = false;

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
        'quotation_date',
        'wage',
        'repair_code',
        'sum_insured',
        'creation_date',
        'total',
        'vat',
        'overall',
        'status',
        'number_ab',
        'price_control_officer',
        'choose_vat_or_not',
        'choose_vat_or_not_1',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quotationitems():HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
