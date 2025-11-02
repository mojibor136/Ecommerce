<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    protected $fillable = [
        'order_id', 'name', 'phone', 'address', 'city', 'area',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
