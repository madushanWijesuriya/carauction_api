<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'make_id'=> 'required',
'model_id'=> 'required',
'status_id'=> 'required',
'body_type_id'=> 'required',
'transmission_id'=> 'required',
'streeing_id'=> 'required',
'door_type_id'=> 'required',
'driver_type_id'=> 'required',
'fuel_type_id'=> 'required',
'exterior_color_id'=> 'required',
'feature_id'=> 'required',
'chassis_no'=> 'required',
'make_at'=> 'required',
'fob_price'=> 'required',
'displacement'=> 'required',
'isUsed'=> 'required',
'mileage'=> 'required',
'grade'=> 'required',
'description'=> 'required',
'private_note'=> 'required',
'sup_name'=> 'required',
'sup_price'=> 'required',
'sup_url'=> 'required',
'market_price'=> 'required',
        ];
    }
}
