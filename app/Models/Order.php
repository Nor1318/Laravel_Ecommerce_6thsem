<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'status',
        'payment_method',
        'payment_reference',
        'cart_data',
    ];

    protected $casts = [
        'cart_data' => 'array',
    ];
}
