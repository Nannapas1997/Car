<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'customer',
        'invoice_number',
        'vehicle_registration',
        'bill_number',
        'amount',
        'vat',
        'aggregate',
        'courier_document',
        'recipient_document',
    ];
    public $timestamps = false;
    const UPDATED_AT = false;
}
