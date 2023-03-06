<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    const UPDATED_AT = false;
    public $timestamps = false;

    protected $fillable = [
        'store',
        'address',
        'postal_code',
        'district',
        'amphoe',
        'province',
        'tel_number'
    ];
}
