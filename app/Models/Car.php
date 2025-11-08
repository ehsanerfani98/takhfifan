<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'gallery',
        'certificate',
        'description',
        'status',
        'vip',
        'keyword',
        'user_id',
        'brand_id',
        'car_model_id',
    ];

    protected $casts = [
        'gallery' => "json",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function car_model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(CarAttributeValue::class);
    }

    public function fileItemValues()
    {
        return $this->hasMany(CarFileItemValue::class);
    }

    public function setGalleryAttribute($value)
    {
        if (is_string($value)) {
            $value = json_decode($value, true);
        }
        $this->attributes['gallery'] = json_encode($value);
    }

    // متد دستی برای گرفتن مقدار
    public function valueOf($slugOrName)
    {
        return $this->attributeValues()->valueOf($slugOrName);
    }

    public function getGearboxAttribute()
    {
        return $this->valueOf('gearbox');
    }

    public function getKiloMeterAttribute()
    {
        return $this->valueOf('kilometer');
    }

    public function getPriceAttribute()
    {
        return $this->valueOf('price');
    }

    public function fileRatings()
    {
        return $this->hasMany(CarFileRating::class);
    }

    public function scopeOrderByAttribute($query, $attributeSlug, $direction = 'asc')
    {
        return $query->join('car_attribute_values as cav_' . $attributeSlug, function ($join) use ($attributeSlug) {
            $join->on('cars.id', '=', 'cav_' . $attributeSlug . '.car_id')
                ->join('attributes as a_' . $attributeSlug, function ($join) use ($attributeSlug) {
                    $join->on('cav_' . $attributeSlug . '.attribute_id', '=', 'a_' . $attributeSlug . '.id')
                        ->where('a_' . $attributeSlug . '.slug', $attributeSlug);
                });
        })
            ->orderBy('cav_' . $attributeSlug . '.value_number', $direction)
            ->select('cars.*');
    }
}
