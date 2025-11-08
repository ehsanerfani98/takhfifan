<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'thumbnail',
        'cover',
        'link',
        'order',
        'is_active',
    ];
}
