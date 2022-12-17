<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'make_id',	'model_id',	'status_id', 'body_type_id', 'transmission_id',	'streeing_id',	'door_type_id',	'driver_type_id', 'fuel_type_id', 'exterior_color_id', 'feature_id', 'chassis_no', 'make_at', 'fob_price', 'displacement', 'isUsed', 'mileage', 'grade', 'cover_image_full_url', 'cover_image_file', 'description', 'private_note', 'sup_name', 'sup_price', 'sup_url', 'market_price',
        'engine_id','shipping_country_id','fort_id','gear_box_id', 'lot_number', 'seats', 'odometer', 'interior_cond'
    ];

    public function make()
    {
        return $this->belongsTo(VhMaker::class,'make_id','id');
    }
    public function make_id()
    {
        return $this->belongsTo(VhMaker::class,'make_id','id');
    }
    public function model()
    {
        return $this->belongsTo(VhModel::class,'model_id','id');
    }
    public function model_id()
    {
        return $this->belongsTo(VhModel::class,'model_id','id');
    }
    public function bodyType()
    {
        return $this->belongsTo(VhBodyType::class,'body_type_id','id');
    }
    public function body_type_id()
    {
        return $this->belongsTo(VhBodyType::class,'body_type_id','id');
    }
    public function status_id()
    {
        return $this->belongsTo(VhStatus::class,'status_id','id');
    }
    public function transmission()
    {
        return $this->belongsTo(VhTransmission::class,'transmission_id','id');
    }
    public function transmission_id()
    {
        return $this->belongsTo(VhTransmission::class,'transmission_id','id');
    }
    public function inqueries()
    {
        return $this->hasMany(Inquery::class,'vehicle_id','id');
    }
    public function images()
    {
        return $this->hasMany(VhImages::class,'vehicle_id','id');
    }
    public function streeing()
    {
        return $this->belongsTo(VhStreeing::class,'streeing_id','id');
    }
    public function streeing_id()
    {
        return $this->belongsTo(VhStreeing::class,'streeing_id','id');
    }
    public function doorType()
    {
        return $this->belongsTo(VhDoorTypes::class,'door_type_id','id');
    }
    public function door_type_id()
    {
        return $this->belongsTo(VhDoorTypes::class,'door_type_id','id');
    }
    public function driverType()
    {
        return $this->belongsTo(VhDriveTypes::class,'driver_type_id','id');
    }
    public function driver_type_id()
    {
        return $this->belongsTo(VhDriveTypes::class,'driver_type_id','id');
    }
    public function fuelType()
    {
        return $this->belongsTo(VhFuelTypes::class,'fuel_type_id','id');
    }
    public function fuel_type_id()
    {
        return $this->belongsTo(VhFuelTypes::class,'fuel_type_id','id');
    }
    public function colors()
    {
        return $this->belongsTo(VhExteriorColor::class,'exterior_color_id','id');
    }
    public function exterior_color_id()
    {
        return $this->belongsTo(VhExteriorColor::class,'exterior_color_id','id');
    }
    public function features()
    {
        return $this->belongsTo(VhFeatures::class,'feature_id','id');
    }
    public function feature_id()
    {
        return $this->belongsTo(VhFeatures::class,'feature_id','id');
    }
}
