<?php


namespace App\Http\CustomFilters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchTextFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        if ($property === 'vehicle_name') {
            $query->whereHas('vehicle', function ($q) use ($value) {
                return $q->where('title', $value);
            });
        } else if ($property === 'chassis_no') {
            $query->whereHas('vehicle', function ($q) use($value) {
                return $q->where('chassis_no', $value);
            });
        }else {
            $query->where(function ($q) use ($value){
                return $q->whereHas('make', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('model',function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('bodyType', function($q) use($value){
                    return $q->where('name', $value);
                });
            });
        }

    }
}
