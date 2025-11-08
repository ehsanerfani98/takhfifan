<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Video extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'video',
        'subtitle',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
