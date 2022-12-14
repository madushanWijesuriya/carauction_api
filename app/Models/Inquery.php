<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'vehicle_id',
        'country_id',
        'email',
        'cell_no',
        'port_name',
        'mobile_no',
        'message',
    ];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class,'vehicle_id','id');
    }
    public function country_id()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
}
