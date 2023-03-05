<?php

namespace App\Models;

use App\Scopes\HasChooseGarageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CashReceipt extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'disbursement_amount',
        'buy_consumables',
        'group_checkbox',
        'date',
        'courier_document',
        'recipient_document'

    ];

    const UPDATED_AT = false;
    public $timestamps = false;

    protected static function booted()
    {
        static::addGlobalScope(new HasChooseGarageScope);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
