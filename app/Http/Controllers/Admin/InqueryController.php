<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\Admin\InqueryResource;
use App\Http\Resources\Admin\VehicleCollection;
use App\Http\Resources\Admin\VehicleResource;
use App\Models\Inquery;
use App\Models\Vehicle;
use App\Models\VhBodyType;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFuelTypes;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use App\Services\ResponseGenerator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class InqueryController extends Controller
{
    public function index(Request $request)
    {
        $query = Inquery::select('*');
        
        $vehicles = QueryBuilder::for($query)
            ->allowedFilters(['name',
            'type',
            'vehicle_id',
            'country_id',
            'email',
            'cell_no',
            'port_name',
            'mobile_no',
            'message'])
            ->allowedSorts(['name',
            'type',
            'vehicle_id',
            'country_id',
            'email',
            'cell_no',
            'port_name',
            'mobile_no',
            'message']);
    
            if( !$request->has('noPagination')) {
                $vehicles = $vehicles->paginate($request['paginate'] <= 50 ? $request['paginate'] : null);
            } else {
                $vehicles = $vehicles->get();
            }

            return InqueryResource::collection($vehicles);
    }

    public function update(UpdateVehicleRequest $request, $id)
    {
    
    }

    public function destroy($id)
    {
    
    }
}
