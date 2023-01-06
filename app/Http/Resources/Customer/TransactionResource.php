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

class TransactionResource extends JsonResource
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
        $response['vehicle']['exterior_color_id'] = $vehicle->colors;
        $response['vehicle']['engine_id'] = $vehicle->engine;
        $response['remaining_amount'] = $vehicle->fob_price - $response['paid_amount'];
        return $response;
    }
}
