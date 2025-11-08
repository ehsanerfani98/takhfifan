<?php

namespace App\QueryBuilder\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CarModelFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            $query->whereHas('car_model', function ($q) use ($value) {
                $q->whereIn('slug', $value);
            });
        } else {
            $query->whereHas('car_model', function ($q) use ($value) {
                $q->where('slug', $value);
            });
        }
    }
}