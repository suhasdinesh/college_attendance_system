<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Student;
use App\Teacher;
use App\ClassModel;
use App\AttendanceLog;
use Carbon\Carbon;
use App\Subject;
use Illuminate\Support\Facades\Gate;

class AttendanceController extends Controller
{   
    public function index()
    {
        if(auth()->guest()){
            return redirect(route('voyager.login'));
        }
        elseif(auth()->user()->hasPermission('browse_attendance'))
        {
            return $this->get_data();
        }
        else{
            return abort(403,'Unauthorized Action');
        }
        //     echo 'yes';
         
    }

    public function get_data()
    {
        $c_list=ClassModel::all(['id','name']);
        $teacher=Teacher::all(['id','first_name']);
        $subject=Subject::all(['id','subject_name']);
        return view('attendance/get_data',compact('c_list','teacher','subject'));
        // return $subject;

    }

    //
    public function fetch_students(Request $class)
    {
        
        $s_class=$class->input('class');
        $teacher_id= $class->input('teacher');
        $subject_id= $class->input('subject');
        $students=Student::where('student_class','=',$s_class)->get();
        $class_counter=Subject::find($subject_id);
        $class_counter->total_classes_conducted=$class_counter->total_classes_conducted+1;
        $class_counter->save();
        return view('attendance/mark_attendance',compact('students','s_class','teacher_id','subject_id'));
        
    }

    public function take_attendance(Request $data)
    {
        $date=Carbon::today()->format('Y-m-d');
        $i=0;
            foreach($data->student_id as $student)
            {
                $attendance=new AttendanceLog;
                $attendance->date=$date;
                $attendance->student_id=$student;
                $attendance->teacher_id=$data->teacher_id;
                $attendance->status=$data->status[$i];
                $attendance->subject_id=$data->subject;
                $attendance->class_id=$data->class;
                $st[$i]=$attendance;
                $i++;
                $attendance->save();
            }

            return view('attendance.done',compact('st'));                
    }


    public function view()
    {
        if(auth()->guest())
        {
            return redirect(route('voyager.login'));
        }
        else if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('Teacher'))
        {
            $c_list=ClassModel::all();     
            return view('attendance.view',compact('c_list'));
        }
        else
        {
            return abort(403,'Unauthorized Action');
        }
        
    }
   
    public function fetch(Request $request)
    {
        $class=$request->class;
        $students=Student::where('student_class','=',$class)->get();
        $subject=Subject::where('class_id','=',$class)->get(['id','subject_name']);
        
        return response([$students,$subject]);
    }
    public function fetch_post(Request $request)
    {
        $st_id=$request->student_id;
        $sub_id=$request->subject;
        $attendance=AttendanceLog::where('student_id','=',$st_id)->where('subject_id','=',$sub_id)->get();
        return response($attendance);    
    }

    public function view2(){
        if(auth()->guest())
        {
            return redirect(route('voyager.login'));
        }
        else if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('Teacher'))
        {
        $c_list=ClassModel::all();
        return view('attendance.view_single',compact('c_list'));
        }
        else
        {
            return abort(403,'Unauthorized Action');
        }

        
    }

    public function send_student(Request $request){
        $s_class=$request->class;    
        $st_list=Student::where('student_class','=',$s_class)->get(['id','first_name']);
        return response($st_list);  
    }

    public function single_student_data(Request $request){
        $st_id=$request->student_id;
        $from_date=$request->from_date;
        $end_date=$request->to_date;
        $student=Student::where('id','=',$st_id)->get('student_id');
        // $attendance =AttendanceLog::where('student_id','=',$student[0]->student_id)
        //                 ->wherebetween('date',[$from_date,$end_date])
        //                 ->crossJoin('subject')
        //                 ->get();
        $attendance=AttendanceLog::where('student_id','=',$student[0]->student_id)
                                    ->wherebetween('date',[$from_date,$end_date])
                                    ->join('subjects','subjects.id','=','attendance_logs.subject_id')
                                    ->get(['date','status','subject_name']);
        return response($attendance);
    }
    public function class_wise()
    {
        if(auth()->guest())
        {
            return redirect(route('voyager.login'));

        }
        else if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('Teacher'))
        {
            $class_list=ClassModel::all();
            return view('attendance.class_wise',compact('class_list'));
        }
        else{
            return abort(403,'Unauthorized Action');
        }
    }

    public function class_wise_data(Request $request)
    {
        $class_id=$request->s_class;
        $students=Student::where('student_class',$class_id)->get();
        foreach($students as $student){
        $attendance[]=AttendanceLog::where('attendance_logs.class_id',$class_id)
                                    ->where('student_id',$student->student_id)
                                    ->groupBy('subject_id')
                                    ->join('subjects','attendance_logs.subject_id','subjects.id')
                                    ->selectRaw('sum(status) as Total_attended,subject_name,total_classes_conducted')
                                    ->get();
        $student_associated[]=$student->first_name;
        
        }
        
        return response([$student_associated,$attendance]);
    }
}
// SELECT a.date,s.subject_name, a.status FROM attendance_logs as a,subjects as s where a.date between '2020-12-01' and '2020-12-30' and  a.student_id='1845SB7020' and a.subject=s.id;
    