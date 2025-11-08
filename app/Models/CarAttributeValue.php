<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarAttributeValue extends Model
{
    protected $fillable = [
        'car_id',
        'attribute_id',
        'attribute_value_id',
        'value_string',
        'value_number',
        'value_boolean',
        'value_boolean_label',
        'sort_order'
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function scopeValueOf($query, string $slugOrName)
    {
        return $query->whereHas('attribute', function ($q) use ($slugOrName) {
            $q->where('slug', $slugOrName)
                ->orWhere('name', $slugOrName);
        })->first()?->formatted_value;
    }

    public function getFormattedValueAttribute()
    {
        // اگر نوع boolean است
        if ($this->attribute?->type === 'boolean' && $this->value_boolean !== null) {
            $labels = $this->value_boolean_label
                ? array_map('trim', explode(',', $this->value_boolean_label))
                : [];
            $trueLabel  = $labels[0] ?? 'بله';
            $falseLabel = $labels[1] ?? 'خیر';
            return $this->value_boolean ? $trueLabel : $falseLabel;
        }

        // اگر نوع select است
        if ($this->attribute?->type === 'select' && $this->attributeValue) {
            return $this->attributeValue->value; // مقدار واقعی از جدول attribute_values
        }

        // اگر عدد باشد و نیاز به فرمت هزارگان دارد
        $value = $this->value_string ?? $this->value_number;
        if ($this->attribute?->format_thousands && is_numeric($value)) {
            return number_format($value);
        }

        return $value;
    }
}
