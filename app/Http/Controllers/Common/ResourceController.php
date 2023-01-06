<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\NewsLetter;
use App\Models\VhBodyType;
use App\Models\VhCountryFort;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhEngine;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFort;
use App\Models\VhFuelTypes;
use App\Models\VhGearType;
use App\Models\VhMakeModel;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStatus;
use App\Models\VhOdometer;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ResourceController extends Controller
{
    public function getMakerList(){
        return response()->json(['data' => VhMaker::select('id', 'name')->get()]);
    }
    public function getModelList($make_id){

        $model_ids = VhMakeModel::where('make_id',$make_id)->pluck('model_id')->toArray();
        return response()->json(['data' => VhModel::select('id', 'name')->whereIn('id',$model_ids)->get()]);
    }
    public function getStatusList(){
        return response()->json(['data' => VhStatus::select('id', 'name')->get()]);
    }
    public function getbodyTypeList(){
        return response()->json(['data' => VhBodyType::select('id', 'name')->get()]);
    }
    public function getTransmissionList(){
        return response()->json(['data' => VhTransmission::select('id', 'name')->get()]);
    }
    public function getStreeingsList(){
        return response()->json(['data' => VhStreeing::select('id', 'name')->get()]);
    }
    public function getDoorTypesList(){
        return response()->json(['data' => VhDoorTypes::select('id', 'name')->get()]);
    }
    public function getCountriesList(){
        return response()->json(['data' => Country::select('id', 'name')->get()]);
    }
    public function getFortList($country){
        $model_ids = VhCountryFort::where('country_id',$country)->pluck('fort_id')->toArray();
        return response()->json(['data' => VhFort::select('id', 'name')->whereIn('id',$model_ids)->get()]);
    }
    public function getDriveTypesList(){
        return response()->json(['data' => VhDriveTypes::select('id', 'name')->get()]);
    }
    public function getFuelTypesList(){
        return response()->json(['data' => VhFuelTypes::select('id', 'name')->get()]);
    }
    public function getExteriorColorsList(){
        return response()->json(['data' => VhExteriorColor::select('id', 'name')->get()]);
    }
    public function getFeaturesList(){
        return response()->json(['data' => VhFeatures::select('id', 'name')->get()]);
    }
    public function getRoleList(){
        return response()->json(['data' => Role::select('id','name')->get()]);
    }
    public function getEngineList(){
        return response()->json(['data' => VhEngine::select('id', 'name')->get()]);
    }
    public function getGearsList(){
        return response()->json(['data' => VhGearType::select('id', 'name')->get()]);
    }

    public function getNewsLettersList(){
        return response()->json(['data' => NewsLetter::select('id','name')->get()]);
    }
    public function getOdometersList(){
        return response()->json(['data' => VhOdometer::select('id','name')->get()]);
    }
}
