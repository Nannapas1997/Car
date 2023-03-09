<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PriceControlBills extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    const UPDATED_AT = false;

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
        'labor_price',
        'price_offer',
        'wage_stop',
        'price_spare_parts'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
