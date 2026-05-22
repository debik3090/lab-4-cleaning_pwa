<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'address_id',
        'time_slot_id',
        'status',
        'total_price',
        'payment_method',
        'payment_status',
        'comment',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

