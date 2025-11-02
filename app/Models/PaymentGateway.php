<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = ['type', 'number' , 'app_key', 'app_secret', 'username', 'password', 'base_url', 'status' , 'option'];
}
