<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'status'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($attribute) {
            if ($attribute->values()->count() > 0) {
                throw new \Exception('Cannot delete this attribute because it has attribute values.');
            }
        });
    }
}
