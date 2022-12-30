<?php


namespace App\Http\CustomFilters;

use Carbon\Carbon;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
       if (strpos($value, ' - ')) {
        $dates = explode(' - ', $value);
        $query->whereBetween('make_at', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
       }
        // strpos($searchValue, ' - ');    
        // $query->whereBetween('make_at', )
    }
}
