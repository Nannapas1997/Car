<?php

namespace App\Models;

use App\Scopes\HasChooseGarageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Invoice extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const UPDATED_AT = false;
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'job_number',
        'customer',
        'invoice_number',
        'good_code',
        'vehicle_registration',
        'items',
        'amount',
        'vat',
        'aggregate',
        'courier_document',
        'recipient_document',
        'code_c0_c7',
        'price',
        'spare_code',
        'spare_cost',
        'choose_vat_or_not',
        'INV_number',
        'biller',
        'bill_payer',
        'choose_garage',
        'insu_company_name',
        'brand',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceItems():HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function booted()
    {
        static::addGlobalScope(new HasChooseGarageScope);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
