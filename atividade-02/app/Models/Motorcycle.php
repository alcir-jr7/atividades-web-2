<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    protected $fillable = ['brand','model','type','year','engine_capacity','has_abs'];
}
