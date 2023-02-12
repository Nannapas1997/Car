<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashReceipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'disbursement_amount',
        'buy_consumables',
        'group_checkbox',
        'forerunner',
        'financial',

    ];
    const UPDATED_AT = false;
    public $timestamps = false;
}
