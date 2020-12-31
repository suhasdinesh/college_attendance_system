<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AttendanceLog extends Model
{
    protected $table='attendance_logs';
    
    protected $fillable=['date','student_id','subject','class','teacher_id','status'];
}
