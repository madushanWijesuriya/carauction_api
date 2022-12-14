<?php


namespace App\Http\CustomFilters;

use App\Models\Inquery;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class InqueryVehicleFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        $query->whereHas('vehicle', function($q) use($value,$property){
            return $q->where($property, $value);
        });
    }
}
