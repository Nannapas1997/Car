<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'picking_list',
        'parts_list',
        'spare_code',
        'quantity',
        'unit',
        'order',
    ];
    public $timestamps = false;
    // turn off only updated_at
    const UPDATED_AT = false;
}
