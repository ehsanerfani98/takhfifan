<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'icon',
        'slug',
    ];

    public function carModels()
    {
        return $this->hasMany(CarModel::class, 'brand_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'brand_attributes')
                    ->withPivot('sort_order', 'is_required')
                    ->withTimestamps();
    }
}
