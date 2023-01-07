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
        if ($property === 'make_at')
            $query->whereBetween('make_at', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
        else if ($property === 'eta')
            $query->whereBetween('eta', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
        else if ($property === 'etd')
            $query->whereBetween('etd', [Carbon::parse($dates[0])->startOfDay(), Carbon::parse($dates[1])->endOfDay()]);
        else if ($property === 'make_at_range')
            $query->whereBetween('make_at', [Carbon::create($dates[0])->startOfYear(), Carbon::create($dates[1])->endOfYear()]);
       }
        // strpos($searchValue, ' - ');
        // $query->whereBetween('make_at', )
    }
}
