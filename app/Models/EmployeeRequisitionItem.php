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

    protected $fillable = [
        'order',
        'employee_lists',
        'disbursement_amount',
        'input',
        'financial',

    ];
    const UPDATED_AT = false;
    public $timestamps = false;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
