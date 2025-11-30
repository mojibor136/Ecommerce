<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'product_id',
        'product_variant_id',
        'product_type',
        'campaign_title',
        'campaign_description',
        'banner_image',
        'video_url',
        'review_image',
        'description_title',
        'description',
        'why_buy_from_us',
        'status',
    ];

    protected $casts = [
        'banner_image' => 'array',
        'review_image' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id', 'id');
    }
}
