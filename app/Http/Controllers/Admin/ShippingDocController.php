<?php

namespace App\Http\Controllers\Admin;

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
        $query = VehicleDoc::select('*');

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

    public function store(Request $request){
        $validate = Validator::make($request->all(),
        [
            'vehicle_id' => 'required',
            'country_id' => 'required',
            'customer_id' => 'required',
            'etd' => 'required',
            'eta' => 'required',
            'doc_1' => 'required',
            'doc_2' => 'required',
            'doc_3' => 'required',
            'pol' => 'required',
            'pod' => 'required',
            'consignee_name' => 'required',
            'yard_location' => 'required',
            'doc' => 'required',
        ]);

        try {
            $result =  DB::transaction(function () use ($request) {
                $docs = ImageService::saveMultipleImages($request,'doc', '/client/shipingDocs/'.$request->customer_id. '/' .$request->vehicle_id);

                $shipingDoc = VehicleDoc::create($request->all());
                $shipingDoc->update(["doc_1" => $docs[0]["full_url"] , "doc_2" => $docs[1]["full_url"], "doc_3" => $docs[2]["full_url"]]);

                return true;
            });

            if($result) return response()->json(['message' => 'Successfully Added'],200);
            else return response()->json(['message' => 'cant added'],500);
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }



    }

    public function update(Request $request, $id){
        $validate = Validator::make($request->all(),
        [
            'country_id' => 'required',
            'etd' => 'required',
            'eta' => 'required',
            'pol' => 'required',
            'pod' => 'required',
            'consignee_name' => 'required',
            'yard_location' => 'required',
            'doc' => 'required',
        ]);

        try {
            $result =  DB::transaction(function () use ($request, $id) {
                //delete current images
                $shipingDoc = VehicleDoc::find($id);
                if(count($request->file('doc')) > 0) {

                    if ($shipingDoc->doc_1) {

                        unlink(public_path() . $shipingDoc->doc_1);
                    }
                    if($shipingDoc->doc_2) {
                        unlink(public_path() .'/'. $shipingDoc->doc_2);
                    }
                    if ($shipingDoc->doc_3) {
                        unlink(public_path() .'/'. $shipingDoc->doc_3);
                    }
                }

                $docs = ImageService::saveMultipleImages($request,'doc', '/client/shipingDocs/'.$shipingDoc->customer_id. '/' .$shipingDoc->vehicle_id);

                $shipingDoc->update($request->all());
                $shipingDoc->update(["doc_1" => $docs[0]["full_url"] , "doc_2" => $docs[1]["full_url"], "doc_3" => $docs[2]["full_url"]]);

                return true;
            });

            if($result) return response()->json(['message' => 'Successfully Added'],200);
            else return response()->json(['message' => 'cant added'],500);
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }

    }
}
