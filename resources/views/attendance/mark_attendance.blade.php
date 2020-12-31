@extends('voyager::master')

@section('content')
    {{Form::open(array('method'=>'post','action' => 'AttendanceController@take_attendance'))}}
    <table class="table table-bordered">
    <tr>
    <th>Name</th>
    <th>Student_ID</th>
    
    <th>Status</th>
    </tr>
    @foreach($students As $student)
    <tr>
    <td>{{Form::label('student_name[]',$student->first_name) }}</td>
    <td>{{$id=$student->student_id}}{{Form::hidden('student_id[]',$id)}}</td>
    <td>@php echo Form::select('status[]',['1' => 'Present' , '0' => 'Absent']);@endphp</td>
    {{Form::hidden('teacher_id',$teacher_id)}}  
    {{Form::hidden('subject',$subject_id)}}
    {{Form::hidden('class',$s_class)}}
    {{Form::close()}}
    <td>{{$loop->index+1}}</td>
    @endforeach
    </tr>
    </table>
    {{Form::submit('Submit')}}
    
@endsection 