<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeRequisitionItem extends Model
{
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
}
