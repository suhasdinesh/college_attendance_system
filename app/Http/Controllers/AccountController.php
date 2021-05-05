<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AccountController extends Controller
{
    //
    public function index(){
        if(auth()->guest())
        {
            return view('register');
        }
        else{
            return redirect()->route('voyager.dashboard');
        }
    }

    public function store(Request $request)
    {
        $user=new User;
        $user->name=$request->name;
        $input['email']=$request->email;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->role_id=2;
        // $user->save();
        $rules = array('email' => 'unique:users');
        $validator=Validator::make($input,$rules);
        if($validator->fails())
        {
            return response('0');
        }
        else{
            $user->save();
            return response('1');
        }
        
    }
}
