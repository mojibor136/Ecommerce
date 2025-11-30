<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'brand', 'orders', 'hot_deal', 'desc', 'sku', 'type', 'new_price', 'old_price', 'buy_price', 'stock', 'category_id', 'subcategory_id', 'status'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function activeReviews()
    {
        return $this->reviews()->where('status', 1);
    }

    public function averageRating()
    {
        return round($this->activeReviews()->avg('rating') ?? 0, 1);
    }

    public function reviewsCount()
    {
        return $this->activeReviews()->count();
    }

    public function landingPage()
    {
        return $this->hasOne(LandingPage::class, 'product_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($product) {
            if (! $product->slug) {
                $product->slug = Str::slug($product->name);
            }

            if (! $product->brand) {
                $setting = Setting::first();
                $product->brand = $setting->brand ?? null;
            }
        });

        static::updating(function ($product) {
            if (! $product->slug) {
                $product->slug = Str::slug($product->name);
            }

            if (! $product->brand) {
                $setting = Setting::first();
                $product->brand = $setting->brand ?? null;
            }
        });
    }
}
