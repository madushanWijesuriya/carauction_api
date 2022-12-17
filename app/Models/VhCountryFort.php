<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VhCountryFort extends Model
{
    use HasFactory;
    protected $fillable = ['country_id','fort_id'];

}
