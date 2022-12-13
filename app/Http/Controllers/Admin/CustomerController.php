<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\Admin\CustomerResource;
use App\Http\Resources\Admin\VehicleCollection;
use App\Http\Resources\Admin\VehicleResource;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Services\ResponseGenerator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::select('*');
        
        $customers = QueryBuilder::for($query)
            ->allowedFilters(['name','email','country_id', 'isActive'])
            ->allowedSorts(['name','email','country_id']);
    
            if( !$request->has('noPagination')) {
                $customers = $customers->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $customers = $customers->get();
            }
            return CustomerResource::collection($customers);
    }

    public function create()
    {
        //
    }

    public function store(CreateVehicleRequest $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $vehicle = Vehicle::create($request->all());

                return $vehicle;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return new VehicleResource($vehicle);
    }
    public function changeStatus(Request $request, $id)
    {
        $customer = Customer::find($id);
        $customer->update(['isActive' => !$customer->isActive]);
        return response()->json(['message' => 'Successfully updated'],200);
    }

    public function storeMaker(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $maker = VhMaker::create($request->all());
                return $maker;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function storeModel(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhModel::create($request->all());
                $makerModel = VhMakeModel::create(collect($request->all())->merge(['model_id' => $model->id])->toArray());

                return $makerModel;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function update(UpdateVehicleRequest $request, $id)
    {
        try{
            $result = DB::transaction(function () use ($request,$id) {
                $vehicle = Vehicle::findOrFail($id);
                $vehicle->update($request->all());
                return $vehicle;
            });

            if($result){
                return new VehicleResource($result);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function destroy($id)
    {
        try{
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            return response()->json(['message' => 'Successfully Deleted'],200);
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
