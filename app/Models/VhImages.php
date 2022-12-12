<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VhImages extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id','full_url', 'file'];

}
