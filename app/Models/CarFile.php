<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarFile extends Model
{

    protected $fillable = ['title'];

    public function items()
    {
        return $this->hasMany(CarFileItem::class);
    }

    public function ratings()
    {
        return $this->hasMany(CarFileRating::class);
    }
}