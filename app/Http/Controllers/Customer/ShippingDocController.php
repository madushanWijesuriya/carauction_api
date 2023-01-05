<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\CountryContent;
use App\Models\Page;
use App\Http\CustomFilters\DateRangeFilter;
use App\Http\CustomFilters\SearchTextFilter;
use App\Http\Resources\Admin\ShippingDocResource;
use App\Models\VehicleDoc;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;

class ShippingDocController extends Controller
{
    public function index(Request $request){
        $query = VehicleDoc::select('*')->where('customer_id', auth()->user()->id);

        $result = QueryBuilder::for($query)
            ->allowedFilters(['eta','etd',
            AllowedFilter::custom('eta', new DateRangeFilter),
            AllowedFilter::custom('etd', new DateRangeFilter),
            AllowedFilter::custom('vehicle_name', new SearchTextFilter),
            AllowedFilter::custom('chassis_no', new SearchTextFilter),
            ])
            ->allowedSorts(['country_id']);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

        return ShippingDocResource::collection($result);
    }

}
