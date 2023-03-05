<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Requisition extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = [
        'job_number',
        'vehicle_registration',
        'input',
        'pickup_time',
        'picking_list',
        'parts_list',
        'spare_code',
        'quantity',
        'forerunner',
        'approver',
        'unit',
        'date'
    ];
    public $timestamps = false;
    // turn off only updated_at
    const UPDATED_AT = false;

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requisitionitems():HasMany
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
