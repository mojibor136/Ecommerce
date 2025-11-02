<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name', 'whatsapp' , 'facebook' , 'phone' , 'email' , 'shipping_charge' , 'brand' , 'hot_deals' , 'meta_title', 'meta_tag', 'meta_desc', 'footer', 'icon', 'favicon'];

    protected $casts = [
        'meta_tag' => 'array',
        'shipping_charge' => 'array',
    ];
}
