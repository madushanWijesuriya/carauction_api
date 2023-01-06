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

class LedgerResource extends JsonResource
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
        $freight_amount = 0;
        $total_sale = $freight_amount + $vehicle->fob_price;
        $response['debit'] = $total_sale - $response['paid_amount'];
        $response['credit'] = $response['paid_amount'];
        $response['balance'] = $response['debit'] - $response['credit'];
        return $response;
    }
}
