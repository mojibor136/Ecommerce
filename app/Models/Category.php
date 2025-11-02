<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'status'];

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($category) {
            if ($category->subcategories()->count() > 0) {
                throw new \Exception('Cannot delete this category because it has subcategories.');
            }

            if ($category->products()->count() > 0) {
                throw new \Exception('Cannot delete this category because it has products.');
            }
        });
    }
}
