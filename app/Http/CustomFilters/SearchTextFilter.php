<?php


namespace App\Http\CustomFilters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchTextFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
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
