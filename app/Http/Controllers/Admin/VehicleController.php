<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\Admin\VehicleCollection;
use App\Http\Resources\Admin\VehicleResource;
use App\Models\Vehicle;
use App\Models\VhBodyType;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFuelTypes;
use App\Models\VhImages;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use App\Services\ImageService;
use App\Services\ResponseGenerator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::select('*');
        
        $vehicles = QueryBuilder::for($query)
            ->allowedFilters(['make_id',	'model_id',	'status_id', 'body_type_id', 'transmission_id',	'streeing_id',	'door_type_id',	'driver_type_id', 'fuel_type_id', 'exterior_color_id', 'feature_id', 'chassis_no', 'make_at', 'fob_price', 'displacement', 'isUsed', 'mileage', 'grade', 'cover_image', 'description', 'private_note', 'sup_name', 'sup_price', 'sup_url', 'market_price'])
            ->allowedSorts(['id', 'make_id',	'model_id',	'status_id', 'body_type_id', 'transmission_id',	'streeing_id',	'door_type_id',	'driver_type_id', 'fuel_type_id', 'exterior_color_id', 'feature_id', 'chassis_no', 'make_at', 'fob_price', 'displacement', 'isUsed', 'mileage', 'grade', 'cover_image', 'description', 'private_note', 'sup_name', 'sup_price', 'sup_url', 'market_price']);
    
            if( !$request->has('noPagination')) {
                $vehicles = $vehicles->paginate(50);
            } else {
                $vehicles = $vehicles->get();
            }

            return VehicleResource::collection($vehicles);
    }

    public function create()
    {
        //
    }

    public function store(CreateVehicleRequest $request)
    {
        try{
            
            $result = DB::transaction(function () use ($request) {

                foreach ($request->file('image') as $key => $image) {
                    # code...
                }

                $vehicle = Vehicle::create($request->all());

                //if (env('APP_ENV') == 'local') {
                    $images = ImageService::saveMultipleImages($request,'image', '/vehicle/images/'.$vehicle->id);
                    if ($images) {
                        foreach ($images as $key => $value) {
                            VhImages::create([
                                'vehicle_id' => $vehicle->id,
                                'full_url' => $value['full_url'],
                                'file' => $value['file'],
                            ]);
                         }
                    }
                    $cover_image = ImageService::saveImage($request,'cover_image', '/vehicle/images/'.$vehicle->id.'/cover_images');
                    if ($cover_image) {
                        $vehicle->update([
                            'cover_image_file' => $cover_image['file'],
                            'cover_image_full_url' => $cover_image['full_url'],
                        ]);
                    }
                //}
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
    public function storeBodyType(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhBodyType::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function storeStreeings(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhStreeing::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function storeDoorTypes(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhDoorTypes::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function storeDriveTypes(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhDriveTypes::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function storeFuelTypes(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhFuelTypes::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function storeExteriorColors(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhExteriorColor::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function storeFeatures(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhFeatures::create($request->all());

                return $model;
            });

            if($result){
                return response()->json(['message' => 'Successfully Added'],200);
            }
        }catch(Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function storeTransmission(Request $request)
    {
        try{
            $result = DB::transaction(function () use ($request) {
                $model = VhTransmission::create($request->all());

                return $model;
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
