<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ใบรับรถ extends Model
{
    use HasFactory;
    protected $fillable = ['เลขที่งาน','slug'];
    public $timestamps = false;

}
