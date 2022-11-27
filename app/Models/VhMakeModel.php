<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VhMakeModel extends Model
{
    use HasFactory;
    protected $fillable = ['make_id','model_id'];

}
