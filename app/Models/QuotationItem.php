<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory;

    public $timestamps = false;
    const UPDATED_AT = false;

    protected $fillable = [
        'job_number',
        'number',
        'spare_code',
        'list_damaged_parts',
        'quantity',
        'price',
        'sum_insured',
        'creation_date',
        'total',
        'vat',
        'overall',
        'status',
        'total_wage'
    ];
}
