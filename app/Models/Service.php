<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'duration_minutes',
        'is_active',
    ];
}
