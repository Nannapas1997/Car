<?php

namespace App\Models;

use App\Scopes\HasChooseGarageScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CarRelease extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory, SoftDeletes;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'id',
        'job_number',
        'vehicle_registration',
        'save_repair_cost_id',
        'code_c0_c7',
        'price',
        'spare_code',
        'staff_name',
        'staff_position',
        'brand',
        'garage',
        'insu_company_name',
        'policy_number',
        'claim_number',
        'choose_garage',
        'oc_number',
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
