<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SaveRepairCostItem extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    protected $primaryKey = 'id';
    const UPDATED_AT = false;
    public $timestamps = false;

    protected $fillable = [
        'vehicle_registration',
        'code_c0_c7',
        'price',
        'spare_code'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
