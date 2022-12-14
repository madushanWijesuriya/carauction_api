<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function inqueries()
    {
        return $this->hasMany(Inquery::class, 'country_id', 'id');
    }
}
