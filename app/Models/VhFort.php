<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VhFort extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'fort_id', 'id');
    }
}
