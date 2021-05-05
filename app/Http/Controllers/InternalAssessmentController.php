<?php

namespace App\Http\Controllers;
use App\User;
use App\Student;
use App\Teacher;
use App\ClassModel;
use App\AttendanceLog;
use App\InternalAssessment;
use Carbon\Carbon;
use App\Subject;
use Illuminate\Support\Facades\Auth;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class InternalAssessmentController extends Controller
{
    //
    public function index(){
        if(auth()->guest()){
            return redirect()->route('voyager.login');
        }
        elseif(auth()->user()->hasPermission('browse_internal-assessments')){
            // $sub_user=auth()->user()->userable;
            $c_list=ClassModel::all(['id','name']);
            return view('internal_assessment.index',compact('c_list'));
        }
        else{
            return abort(403,"Unauthorized Action");
        }
    }

    public function send_data(Request $request)
    {
        $c_id=$request->class_id;
        $student=Student::where('student_class',$c_id)->get(['student_id','first_name']);
        $subjects=Subject::where('class_id',$c_id)->get(['id','subject_name']);
        return response([$student,$subjects]);
    }

    public function fetch_dataRow(Request $request)
    {
        $c_id=$request->class_id;
        $student_id=$request->student_id;
        $subject_id=$request->subject_id;
        $semester=$request->semester;
        if(!$request->test1)
        {
            $test1=0;
        }
        $dataRow=InternalAssessment::updateorcreate(['student_id'=>$student_id,'semester'=>$semester],
                                        ['subject_id'=>$subject_id,'class_id'=>$c_id,'test1','test2','attendance','assignment']);
        return response($dataRow);
    }
    
    public function store_dataRow(Request $request)
    {
        $c_id=$request->class_id;
        $student_id=$request->student_id;
        $subject_id=$request->subject_id;
        $semester=$request->semester;
        $test1=$request->test1;
        $test2=$request->test2;
        $attendance=$request->attendance;
        $assignment=$request->assignment;
        $total=$request->total;
        $out_of=$request->out_of;
        $dataRow=InternalAssessment::updateorcreate(['student_id'=>$student_id,'semester'=>$semester],
                                        ['subject_id'=>$subject_id,'class_id'=>$c_id,'test1'=>$test1,
                                        'test2'=>$test2,'attendance'=>$attendance,
                                        'assignment'=>$assignment,'total'=>$total,'out_of'=>$out_of]);
        return response($dataRow);
    }

    public function classwiseindex(){
        $class_list=ClassModel::all();
        return view('internal_assessment.classwise',compact('class_list'));
    }

    public function classwise_getDataRows(Request $request){
        $subjects=Subject::where('class_id',$request->class_id)->get();
        $students=Student::where('student_class',$request->class_id)->get();
        return response([$students,$subjects]);
    }

}
