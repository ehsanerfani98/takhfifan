<?php

namespace App\QueryBuilder\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class CarTitleFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if (is_array($value)) {
            $query->where(function ($q) use ($value) {
                foreach ($value as $title) {
                    $q->orWhere('title', 'LIKE', '%' . $title . '%');
                }
            });
        } else {
            $query->where('title', 'LIKE', '%' . $value . '%');
        }
    }
}