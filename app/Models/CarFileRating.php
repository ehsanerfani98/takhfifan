<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarFileRating extends Model
{
    protected $fillable = ['car_file_id', 'car_id', 'rating'];

    protected $casts = [
        'rating' => 'string',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function carFile()
    {
        return $this->belongsTo(CarFile::class);
    }
}