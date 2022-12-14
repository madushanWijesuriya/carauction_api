<?php

namespace App\Http\Resources\Admin;

use App\Models\Content;
use App\Models\Country;
use App\Models\Page;
use App\Models\Vehicle;
use Illuminate\Http\Resources\Json\JsonResource;

class InqueryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $relations = [
            'make_id',
            'model_id',
            'body_type_id',
            'transmission_id',
            'inqueries',
            'images',
            'streeing_id',
            'door_type_id',
            'driver_type_id',
            'fuel_type_id',
            'exterior_color_id',
            'feature_id'
        ];
        $response = parent::toArray($request);
        $response['vehicle_id'] = Vehicle::find($response['vehicle_id'])->load($relations);
        $response['country_id'] = Country::find($response['country_id']);
        return $response;
    }
}
