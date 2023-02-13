<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeRequisition extends Model
{
    use HasFactory;
    protected $fillable = [
        'order',
        'employee_lists',
        'disbursement_amount',
        'input',
        'financial',

    ];
    const UPDATED_AT = false;
    public $timestamps = false;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function employeeitems():HasMany
    {
        return $this->hasMany(EmployeeRequisitionItem::class);
    }
}
