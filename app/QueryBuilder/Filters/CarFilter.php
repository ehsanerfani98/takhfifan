<?php

namespace App\QueryBuilder\Filters;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class CarFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $attribute = Attribute::where('slug', $property)->first();
        if (!$attribute) return;

        $query->whereHas('attributeValues', function ($q) use ($attribute, $value) {
            $q->where('attribute_id', $attribute->id);

            if ($attribute->type === 'select') {
                if (is_array($value)) {
                    $attributeValues = AttributeValue::whereIn('slug', $value)
                        ->where('attribute_id', $attribute->id)
                        ->pluck('id');
                    $q->whereIn('attribute_value_id', $attributeValues);
                } else {
                    $attributeValue = AttributeValue::where('slug', $value)
                        ->where('attribute_id', $attribute->id)
                        ->first();
                    $q->where('attribute_value_id', $attributeValue?->id);
                }
            } elseif ($attribute->type === 'number') {
                $q->where('value_number', $value);
            } elseif ($attribute->type === 'boolean') {
                $q->where('value_boolean', $value);
            } elseif ($attribute->type === 'range') {
                Log::info($value[0]);
                Log::info($value[1]);
                $q->whereBetween('value_number', [$value[0], $value[1]]);
            }
        });
    }
}
