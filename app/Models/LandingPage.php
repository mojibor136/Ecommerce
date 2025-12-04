<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    protected $fillable = [
        'product_id',
        'campaign_slug',
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

    protected static function booted()
    {
        static::creating(function ($landing) {
            if ($landing->campaign_title && empty($landing->campaign_slug)) {
                $landing->campaign_slug = Str::slug($landing->campaign_title);
            }
        });

        static::updating(function ($landing) {
            if ($landing->isDirty('campaign_title')) {
                $landing->campaign_slug = Str::slug($landing->campaign_title);
            }
        });
    }
}
