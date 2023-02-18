<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_code',

    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
