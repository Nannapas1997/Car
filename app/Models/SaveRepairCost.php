<?php

namespace App\Models;

use App\Models\User;
use App\Models\SaveRepairCostItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveRepairCost extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'job_number',
        'customer',
        'vehicle_registration',
        'brand',
        'model',
        'car_year',
        'wage',
        'expense_not_receipt',
        'total',
        'code_c0_c7',
        'price',
        'spare_code',
        'spare_cost',
        'store',
    ];
    public $timestamps = false;
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function saveRepairCostItems():HasMany
    {
        return $this->hasMany(SaveRepairCostItem::class);
    }
// turn off only updated_at
const UPDATED_AT = false;
protected $primaryKey = 'id';

}
