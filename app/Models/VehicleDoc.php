<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleDoc extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'vehicle_id','country_id','customer_id','etd','eta','doc_1','doc_2','doc_3','pol','pod','consignee_name','yard_location'
    ];

    public function vehicle()
    {
        return $this->hasOne(Vehicle::class, 'vehicle_id', 'id');
    }
}
