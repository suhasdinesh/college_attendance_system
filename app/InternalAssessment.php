<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Traits\Translatable;


class InternalAssessment extends Model
{
    protected $fillable = ['student_id','class_id','subject_id','test1','test2','assignment','attendance','total','semester'];
}
