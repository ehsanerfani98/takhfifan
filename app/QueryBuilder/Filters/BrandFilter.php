<?php

namespace App\QueryBuilder\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class BrandFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            $query->whereHas('brand', function ($q) use ($value) {
                $q->whereIn('slug', $value);
            });
        } else {
            $query->whereHas('brand', function ($q) use ($value) {
                $q->where('slug', $value);
            });
        }
    }
}