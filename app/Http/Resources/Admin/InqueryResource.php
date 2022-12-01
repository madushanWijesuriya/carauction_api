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
        $response = parent::toArray($request);
        $response['vehicle_id'] = Vehicle::find($response['vehicle_id']);;
        $response['country_id'] = Country::find($response['country_id']);
        return $response;
    }
}
