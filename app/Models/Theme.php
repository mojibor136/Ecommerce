<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['nav_bg', 'nav_text', 'theme_bg', 'theme_hover', 'theme_text'];
}
