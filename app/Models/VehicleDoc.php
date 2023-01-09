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

    /**
     * Get the vehicle that owns the VehicleDoc
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo(vehicle::class, 'vehicle_id', 'id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
