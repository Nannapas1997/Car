<?php

namespace App\Models;

use App\Scopes\HasChooseGarageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Bill extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public $timestamps = false;
    const UPDATED_AT = false;

    protected $fillable = [
        'job_number',
        'customer',
        'invoice_number',
        'vehicle_registration',
        'bill_number',
        'amount',
        'vat',
        'aggregate',
        'courier_document',
        'recipient_document',
        'choose_garage',
        'choose_vat_or_not',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new HasChooseGarageScope);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
