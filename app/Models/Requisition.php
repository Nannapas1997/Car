<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'vehicle_registration',
        'date',
        'pickup_time',
        'picking_list',
        'parts_list',
        'spare_code',
        'quantity',
        'forerunner',
        'approver',
        'unit',
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
}