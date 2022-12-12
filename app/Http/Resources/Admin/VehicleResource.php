<?php

namespace App\Http\Resources\Admin;

use App\Models\VhBodyType;
use App\Models\VhDoorTypes;
use App\Models\VhDriveTypes;
use App\Models\VhExteriorColor;
use App\Models\VhFeatures;
use App\Models\VhFuelTypes;
use App\Models\VhImages;
use App\Models\VhMaker;
use App\Models\VhModel;
use App\Models\VhStatus;
use App\Models\VhStreeing;
use App\Models\VhTransmission;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\FeatureSet;

class VehicleResource extends JsonResource
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
        $response['make_id'] = VhMaker::find($response['make_id']);
        $response['model_id'] = VhModel::find($response['model_id']);
        $response['status_id'] = VhStatus::find($response['status_id']);
        $response['body_type_id'] = VhBodyType::find($response['body_type_id']);
        $response['transmission_id'] = VhTransmission::find($response['transmission_id']);
        $response['streeing_id'] = VhStreeing::find($response['streeing_id']);
        $response['door_type_id'] = VhDoorTypes::find($response['door_type_id']);
        $response['driver_type_id'] = VhDriveTypes::find($response['driver_type_id']);
        $response['fuel_type_id'] = VhFuelTypes::find($response['fuel_type_id']);
        $response['exterior_color_id'] = VhExteriorColor::find($response['exterior_color_id']);
        $response['feature_id'] = VhFeatures::find($response['feature_id']);
        $response['images'] = VhImages::where('vehicle_id', $response['id'])->get();
        return $response;
    }
}
