<?php

namespace App\QueryBuilder\Sorts;

use App\Models\Attribute;
use Spatie\QueryBuilder\Sorts\Sort;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AttributeSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        // اگر property با - شروع شود، جهت نزولی است
        if (str_starts_with($property, '-')) {
            $property = substr($property, 1);
            $descending = true;
        }

        $attribute = Attribute::where('slug', $property)->first();

        if (!$attribute) {
            return $query;
        }

        $direction = $descending ? 'DESC' : 'ASC';

        // استفاده از Subquery برای جلوگیری از مشکلات JOIN
        if ($attribute->type === 'select') {
            // برای نوع select: از attribute_value_id و CAST value به عدد
            $subQuery = DB::table('car_attribute_values')
                ->join('attribute_values', 'car_attribute_values.attribute_value_id', '=', 'attribute_values.id')
                ->whereColumn('car_attribute_values.car_id', 'cars.id')
                ->where('car_attribute_values.attribute_id', $attribute->id)
                ->select(DB::raw('CAST(attribute_values.value AS UNSIGNED)'))
                ->limit(1);

            return $query->orderBy($subQuery, $direction);
        }
        else if (in_array($attribute->type, ['range', 'number'])) {
            // برای انواع range و number: از value_number مستقیم
            $subQuery = DB::table('car_attribute_values')
                ->whereColumn('car_id', 'cars.id')
                ->where('attribute_id', $attribute->id)
                ->select('value_number')
                ->limit(1);

            return $query->orderBy($subQuery, $direction);
        }
        else {
            return $query;
        }
    }
}