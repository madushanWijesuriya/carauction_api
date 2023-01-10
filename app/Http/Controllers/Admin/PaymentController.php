<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\CountryContent;
use App\Models\Page;
use App\Http\CustomFilters\DateRangeFilter;
use App\Http\CustomFilters\SearchTextFilter;
use App\Http\Resources\Admin\ShippingDocResource;
use App\Http\Resources\Admin\PaymentResource;
use App\Models\VehicleDoc;
use App\Models\Vehicle;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use App\Services\ImageService;

class PaymentController extends Controller
{
    public function index(Request $request){
        $query = Payment::select('*')->with('vehicle');

        $result = QueryBuilder::for($query)
            ->allowedFilters(['vehicle_id','customer_id', 'agent', 'paid_amount',
            AllowedFilter::custom('payment_search_text', new SearchTextFilter),
            ])
            ->allowedSorts(['vehicle_id','customer_id', 'agent', 'paid_amount']);

            if( !$request->has('noPagination')) {
                $result = $result->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $result = $result->get();
            }

        return PaymentResource::collection($result);
    }

    public function store(Request $request){
        $validated = $request->validate([        
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'agent' => 'required',
            'paid_amount' => 'required'
        ]);

        $vehicle = Vehicle::find($request->vehicle_id);
        if($request->paid_amount > $vehicle->fob_price) {
             return response()->json(['message' => 'You cannot enter amount above sale price'],500);
        }

        try {
            $result =  DB::transaction(function () use ($request) {
                if (Payment::create($request->all())) return true;

                return false;
            });

            if($result) return response()->json(['message' => 'Successfully Added'],200);
            else return response()->json(['message' => 'cant added'],500);
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }



    }
    public function show($id){
        
        return new PaymentResource(Payment::find($id));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'customer_id' => 'required|exists:customers,id',
            'agent' => 'required',
            'paid_amount' => 'required'
        ]);
        try {
            $vehicle = Vehicle::find($request->vehicle_id);
        if($request->paid_amount > $vehicle->fob_price) {
             return response()->json(['message' => 'You cannot enter amount above sale price'],500);
        }
            $result =  DB::transaction(function () use ($request, $id) {
                //delete current images
                $payment = Payment::find($id);
                if($payment) {
                    $payment->update($request->all());
                }
                return true;
            });
            if($result) return response()->json(['message' => 'Successfully Updated'],200);

            else return response()->json(['message' => 'cant updated'],500);
        } catch(Exception $e) {
            return response()->json(['message' => $e->getMessage()],500);
        }

    }
}
