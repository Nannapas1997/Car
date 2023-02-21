<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThailandAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'province',
        'amphoe',
        'district',
        'zipcode',
    ];

    public $timestamps = false;
    // turn off only updated_at
    const UPDATED_AT = false;
}
