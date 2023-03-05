<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PurchaseOrder extends Model implements HasMedia
{
    use InteractsWithMedia;
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
        'buyer',
        'approver',
        'parts_list_total',
        'code_c0_c7',
        'buyer',
        'approver',
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
