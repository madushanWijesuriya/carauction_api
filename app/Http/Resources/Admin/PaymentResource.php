<?php

namespace App\Http\Resources\Admin;

use App\Models\Content;
use App\Models\Country;
use App\Models\Vehicle;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
        $response['customer_id'] = Customer::find($response['customer_id']);
        $response['remaining_amount'] = $vehicle->fob_price - $response['paid_amount'];
 
        return $response;
    }
}
