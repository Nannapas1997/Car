<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReceive extends Model
{
    use HasFactory;
    protected $fillable = ['เลือกอู่'];
    // turn off both
public $timestamps = false;

// turn off only updated_at
const UPDATED_AT = false;
}
