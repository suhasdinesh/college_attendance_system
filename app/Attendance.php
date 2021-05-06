<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use App\User;

class Attendance extends Model
{
    protected $table='attendance';
    
    protected $fillable=['date','student_id','subject','class','teacher_id','status'];
    
    // public function boot(){
    //     Gate::define('browse_attendance',function($user){
    //         return $user->hasPermission('browse_attendance');
    //     });
    // }
}
