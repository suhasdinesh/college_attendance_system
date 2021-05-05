<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    protected $table = 'student';

    public function users(){
        return $this->morphToMany('App\User','userable');
    }
   
}
