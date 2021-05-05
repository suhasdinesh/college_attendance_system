<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userable extends Model
{
    //
    protected $table='userables';
    protected $fillable=['user_id','userable_id','userable_type'];
}
