<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'invoice_id', 'ip_address' , 'total', 'discount', 'tracking_id', 'courier_method', 'shipping_charge', 'order_status', 'payment_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function shipping()
    {
        return $this->hasOne(Shipping::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->invoice_id)) {
                $order->invoice_id = strtoupper(Str::random(7));
            }
        });

        static::deleting(function ($order) {
            $order->items()->delete();

            $order->payment()->delete();

            $order->shipping()->delete();
        });
    }
}
