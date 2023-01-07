<?php


namespace App\Http\CustomFilters;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class RangeFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        if ($property === 'mileage_range') {
            $query->whereBetween('mileage', $value);
        }
        else if ($property === 'engine_id_range') {
            $query->whereHas('engine', function($q) use ($value) {
                return $q->whereBetween('name', $value);
            });
        }
    }
}
