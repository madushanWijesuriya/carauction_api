<?php

namespace App\Http\Resources\Admin;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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

        $response['created_at'] = Carbon::parse($response['created_at'])->format('Y-m-d H:i:s');
        $response['updated_at'] = Carbon::parse($response['updated_at'])->format('Y-m-d H:i:s');
        return $response;
    }
}
