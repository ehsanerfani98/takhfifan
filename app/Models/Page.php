<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'featured_image',
        'user_id',
        'is_published',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
