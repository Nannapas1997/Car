<?php

namespace App\Models;

use App\Models\User;
use App\Models\SaveRepairCostItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SaveRepairCost extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'id',
        'job_number',
        'customer',
        'vehicle_registration',
        'brand',
        'model',
        'car_year',
        'wage',
        'expense_not_receipt',
        'total',
        'code_c0_c7',
        'price',
        'spare_code',
        'spare_cost',
        'store',
        'taxpayer_number',
        'contact_name',
        'tel_number',
        'address'
    ];
    public $timestamps = false;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function saveRepairCostItems():HasMany
    {
        return $this->hasMany(SaveRepairCostItem::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }

    const UPDATED_AT = false;
    protected $primaryKey = 'id';

}
