<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveRepairCostItem extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_registration', 'code_c0_c7','price','spare_code'];
    protected $primaryKey = 'id';
    const UPDATED_AT = false;
    public $timestamps = false;
}
