<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VhOdometer extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'odometer_id', 'id');
    }
}
