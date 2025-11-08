<?php

namespace App\QueryBuilder\Sorts;

use Spatie\QueryBuilder\Sorts\Sort;
use Illuminate\Database\Eloquent\Builder;

class CreatedAtSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        // اگر property با - شروع شود، جهت نزولی است
        if (str_starts_with($property, '-')) {
            $property = substr($property, 1);
            $descending = true;
        }

        $direction = $descending ? 'DESC' : 'ASC';
        return $query->orderBy('created_at', $direction);
    }
}