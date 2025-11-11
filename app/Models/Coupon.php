<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_purchase',
        'category_id',
        'expiry_date',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
