<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = ['type', 'api_key', 'secret_key', 'url', 'token', 'status'];
}
