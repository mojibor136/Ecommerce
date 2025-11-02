<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsTracking extends Model
{
    protected $fillable = ['type', 'key', 'status'];
}
