<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
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
    public $timestamps = false;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoiceItems():HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    const UPDATED_AT = false;
    protected $primaryKey = 'id';
}
