<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'service_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
