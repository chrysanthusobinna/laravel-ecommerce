<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_name',
        'quantity',
        'subtotal',
        'size_id',
        'size_name',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
