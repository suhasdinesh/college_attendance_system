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

class AttendanceController extends Controller
{   
    public function index()
    {
        return AttendanceController::get_data();
        // return AttendanceController::fetch_students();        
    }

    public function get_data()
    {
        $c_list=ClassModel::all(['id','name']);
        $teacher=Teacher::all(['id','first_name']);
        $subject=Subject::all(['id','subject_name']);
        return view('attendance/get_data',compact('c_list','teacher','subject'));

    }

    //
    public function fetch_students(Request $class)
    {
        // $students=User::all();
        // $students=Student::join('users','users.id','=','student.user_id')
        //                     ->join('classes','student.student_class','=','classes.id')
        //                     ->get();
        // $c_list=ClassModel::all();
        // $class=1;
        // echo $class;
        $s_class=$class->input('class');
        $teacher_id= $class->input('teacher');
        $subject_id= $class->input('subject');
        $students=Student::where('student_class','=',$s_class)->get();
        return view('attendance/mark_attendance',compact('students','s_class','teacher_id','subject_id'));
        
    }

    public function take_attendance(Request $data)
    {
        $students=Student::all();
        $date=Carbon::today();
        $date2= Carbon::parse($date);
        $attendance=[];
        
        //  foreach($data as $dat) 
        // {
        //     $attendance[]=[
        //         'date' => $date2,
        //         'class' => $data->input('class'),
        //         'subject' => $data->input('subject'),
        //         'teacher_id' => $data->input('teacher_id'),
        //         'student_id' => $data->input('student_id'),
        //         'status' => $data->input('status'),
        //         'created_at' => $date2,
        //     ];
        // }          
        
        foreach($students As $id => $status)
        {
            $attendance[]=[
                'date' => $date2,
                'class' => $data->input('class'),
                'subject' => $data->input('subject'),
                'teacher_id' => $data->input('teacher_id'),
                'student_id' => $status -> student_id,
                'status' => $data->status[$id],
                'created_at' => $date2
            ];
        }
            // AttendanceLog::insert($attendance);
          
            return $this->insert_att($attendance);
            // $query=AttendanceLog::insert($attendance);
            //  return $this->insert_att($attendance);     
              
                
    }

    public function insert_att($attendance)
    {
        foreach($attendance As $att)
        {
             AttendanceLog::insert($att);
        }
        return view('attendance.done',['attendance' => $attendance]);
        
    }

    public function view()
    {
        $c_list=ClassModel::all();     
        return view('attendance.view',compact('c_list'));
    }
   
    public function fetch(Request $request)
    {
        $class=$request->class;
        $students=Student::where('student_class','=',$class)->get();
        $subject=Subject::where('class','=',$class)->get(['id','subject_name']);
        
        return response([$students,$subject]);
    }
    public function fetch_post(Request $request)
    {
        $st_id=$request->student_id;
        $sub_id=$request->subject;
        $attendance=AttendanceLog::where('student_id','=',$st_id)->where('subject','=',$sub_id)->get();
        // $class_name=ClassModel::where('id','=',)
        return response($attendance);    
    }

    public function view2(){
        $c_list=ClassModel::all();
        return view('attendance.view_single',compact('c_list'));
        
    }

    public function send_student(Request $request){
        $s_class=$request->class;
        
        $st_list=Student::where('student_class','=',$s_class)->get(['id','first_name']);
        // return $s_class;
        return response($st_list);  
    }

    public function single_student_data(Request $request){
        $student_id=$request->student_id;
        $from_date=$request->from_date;
        $end_date=$request->to_date;
        
        return response([$student_id,$from_date,$end_date]);
    }
}
