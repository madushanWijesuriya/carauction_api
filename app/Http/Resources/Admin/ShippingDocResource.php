<?php

namespace App\Http\Resources\Admin;

use App\Models\Content;
use App\Models\Country;
use App\Models\Page;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingDocResource extends JsonResource
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
        return $response;
    }
}
