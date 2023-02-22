<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'number',
        'spare_code',
        'list_damaged_parts',
        'quantity',
        'price',
    ];
    public $timestamps = false;

    const UPDATED_AT = false;
}
