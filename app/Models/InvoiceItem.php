<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'code_c0_c7',
        'price',
        'spare_code',
        'spare_cost',

    ];
    public $timestamps = false;
}
