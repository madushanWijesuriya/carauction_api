<?php

namespace App\Http\Resources\Customer;

use App\Models\Vehicle;
use App\Models\VhBodyType;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhEngine;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFuelTypes;
use App\Models\VhGearType;
use App\Models\VhImages;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStatus;
use App\Models\VhOdometer;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\FeatureSet;

class StockResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);

        $vehicle = Vehicle::find($response['vehicle_id']);
        
        if ($vehicle->fob_price <= $response['paid_amount']) {
            $response['status']['name'] = 'Payment Done';
            $response['status']['balance_amount'] = null;
        } else {
            $response['status']['name'] = 'Balance';
            $response['status']['balance_amount'] = $vehicle->fob_price - $response['paid_amount'];
        }
        $response['vehicle']['make_id'] = $vehicle->make;
        $response['vehicle']['model_id'] = $vehicle->model;
        $response['vehicle']['model_id']['year'] = Carbon::parse($vehicle->model->created_at)->format('Y');
        $response['vehicle']['status_id'] = $vehicle->status;
        $response['vehicle']['body_type_id'] = $vehicle->bodyType;
        $response['vehicle']['transmission_id'] = $vehicle->transmission;
        $response['vehicle']['gear_box_id'] = $vehicle->gear; 
        $response['vehicle']['engine_id'] = $vehicle->engine;
        $response['vehicle']['streeing_id'] = $vehicle->streeing;
        $response['vehicle']['door_type_id'] = $vehicle->doorType;
        $response['vehicle']['driver_type_id'] = $vehicle->driverType;
        $response['vehicle']['fuel_type_id'] = $vehicle->fuelType;
        $response['vehicle']['exterior_color_id'] = $vehicle->colors;
        $response['vehicle']['feature_id'] = $vehicle->features;
        $response['vehicle']['odometer_id'] = $vehicle->odometer;
        $response['vehicle']['images'] = $vehicle->images;
        $response['vehicle']['inqueries'] = $vehicle->inqueries;
        return $response;
    }
}
