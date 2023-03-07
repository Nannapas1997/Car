<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmployeeRequisition extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const UPDATED_AT = false;
    public $timestamps = false;

    protected $fillable = [
        'order',
        'employee_lists',
        'disbursement_amount',
        'input',
        'financial',
        'courier_document',
        'approver',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function employeerequisitionitems():HasMany
    {
        return $this->hasMany(EmployeeRequisitionItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
