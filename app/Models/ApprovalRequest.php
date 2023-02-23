<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'job_number',
        'approval_number',
        'noti_number',
        'number_ab',
        'vehicle_registration',
        'amount',
        'insu_company_name',
        'vat',
        'note',
        'aggregate',
        'condition_value',
        'courier_document',
        'recipient_document',
    ];
    public $timestamps = false;

    // turn off only updated_at
    const UPDATED_AT = null;
}
