<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'make_id',	'model_id',	'status_id', 'body_type_id', 'transmission_id',	'streeing_id',	'door_type_id',	'driver_type_id', 'fuel_type_id', 'exterior_color_id', 'feature_id', 'chassis_no', 'make_at', 'fob_price', 'displacement', 'isUsed', 'mileage', 'grade', 'cover_image', 'description', 'private_note', 'sup_name', 'sup_price', 'sup_url', 'market_price'
    ];
}
