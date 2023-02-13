<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'vehicle_registration',
        'model',
        'car_year',
        'store',
        'parts_list',
        'spare_code',
        'price',
        'quantity',
        'aggregate_price',
        'note',
        'courier_document',
        'recipient_document'
    ];
    public $timestamps = false;
// turn off only updated_at
    const UPDATED_AT = false;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function purchaseorderitems():HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
