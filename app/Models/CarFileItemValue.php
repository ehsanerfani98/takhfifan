<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarFileItemValue extends Model
{
    protected $fillable = ['car_id', 'car_file_item_id', 'status', 'status_description'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function carFileItem()
    {
        return $this->belongsTo(CarFileItem::class);
    }
}