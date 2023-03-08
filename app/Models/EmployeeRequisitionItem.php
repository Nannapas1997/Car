<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmployeeRequisitionItem extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const UPDATED_AT = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'order',
        'employee_lists',
        'disbursement_amount',
        'input',
        'financial',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
