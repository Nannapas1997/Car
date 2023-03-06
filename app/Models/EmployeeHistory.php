<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class EmployeeHistory extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    const UPDATED_AT = null;
    const CREATED_AT = null;

    protected $fillable = [
        'employee_code',
        'employee_lists',
        'prefix',
        'name_surname',
        'birthdate',
        'id_card',
        'nationality',
        'address',
        'email',
        'start_work_date',
        'field',
        'technician_team',
        'under_the_cradle',
        'salary',
        'other_money',
        'employee_termination_date',
        'cause',
        'resignation_document',
        'tel_number'

    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('other_files');
    }
}
