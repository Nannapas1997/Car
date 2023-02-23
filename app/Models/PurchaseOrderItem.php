<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'parts_list',
        'spare_code',
        'price',
        'quantity',
        'aggregate_price',
        'code_c0_c7',

    ];
    public $timestamps = false;
    // turn off only updated_at
    const UPDATED_AT = false;
}
