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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
