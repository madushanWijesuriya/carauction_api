<?php


namespace App\Http\CustomFilters;


use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchTextFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property)
    {
        if ($property  === 'payment_search_text' || $property  === 'stock_search_text' 
        || $property  === 'transaction_search_text' || $property  === 'ledger_search_text') {
            return $query->whereHas('vehicle', function ($q) use ($value) {
                return $q->whereHas('make', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('model',function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('bodyType', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('status_id', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('status_id', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('transmission', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('streeing', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('doorType', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('driverType', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('fuelType', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('colors', function($q) use($value){
                    return $q->where('name', $value);
                })->orWhereHas('features', function($q) use($value){
                    return $q->where('name', $value);
                });
                
            });
        }
        if ($property === 'vehicle_name') {
            $query->whereHas('vehicle', function ($q) use ($value) {
                return $q->where('title',  'like', '%'. $value .'%');
            });
        } else if ($property === 'chassis_no') {
            $query->whereHas('vehicle', function ($q) use($value) {
                return $q->where('chassis_no', 'like', '%'. $value .'%');
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
