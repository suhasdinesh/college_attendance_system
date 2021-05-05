<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Teacher extends Model
{
    protected $table = 'teacher';
    public function users(){
        return $this->morphToMany('App\User','userable');
    }
}
