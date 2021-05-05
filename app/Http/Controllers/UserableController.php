<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Teacher;
use App\Userable;
use App\Student;
class UserableController extends Controller
{
    //
    public function index()
    {
        //
        if(auth()->guest()){
            return redirect(route('voyager.login'));
        }
        elseif(auth()->user()->hasPermission('browse_approve_user'))
        {
        $users=User::select('id','email')->whereNotExists(function($query){
            $query->select('user_id')->from('userables')->whereRaw('users.id=userables.user_id');
        })->get();
        return view('user_approval.index',compact('users'));
        }
        else {
            return abort(403,'Unauthorized action');
        }   

    }

    public function create(Request $request){
        $user=User::find($request->id,['id','name']);
        $first_name=$user['name'];
        $role=$request->role;
        if($role=='App\Teacher')
        {

            $teacher = new Teacher;
            $teacher->first_name=$first_name;
            $teacher->save();

            $user->role_id=4;
            $user->save();

            $userable = new Userable;
            $userable->user_id=$request->id;
            $userable->userable_id=$teacher->id;
            $userable->userable_type=$role;
            $userable->save();
            return response($userable);
        }
        else if($role=='App\Student')
        {

            $student = new Student;
            $student->first_name=$first_name;
            $student->save();

            $user->role_id=3;
            $user->save();

            $userable = new Userable;
            $userable->user_id=$request->id;
            $userable->userable_id=$student->id;
            $userable->userable_type=$role;
            $userable->save();
            return response($userable);
        }
        
    }
}
