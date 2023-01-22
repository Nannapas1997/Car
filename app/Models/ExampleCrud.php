<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExampleCrud extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'image_url_1'
    ];

    protected $casts = [];

    protected $appends = [];

    public $timestamps = false;

    const UPDATED_AT = true;
}
