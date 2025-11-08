<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarFileItem extends Model
{
    protected $fillable = ['car_file_id', 'title'];

    public function carFile()
    {
        return $this->belongsTo(CarFile::class);
    }

    public function values()
    {
        return $this->hasMany(CarFileItemValue::class);
    }
}