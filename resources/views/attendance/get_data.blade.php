@extends('voyager::master')

@section('content')
{{ Form::open(array('method' => 'post','action' => 'AttendanceController@fetch_students')) }}
<div class="container" align="center" justify="center">

    <div class="row">
        <div class="col-md-4">
            {{ Form::label('Select A Class') }}
            <select class="form-control" name="class">
                @foreach($c_list As $class)
                    <option value={{ $class->id }} name="class">{{ $class->name }}</option>
                @endforeach
            </select>

        </div>
        <div class="col-md-4">
            {{ Form::label('Teacher Name') }}
            <select class="form-control" name="teacher">
                @foreach($teacher As $teach)
                    <option value={{ $teach->id }} name="teacher_id">{{ $teach->first_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            {{ Form::label('Subject') }}
            <select class="form-control" name="subject">
                @foreach($subject As $sub)
                    <option value={{ $sub->id }} name="subject">{{ $sub->subject_name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <button class="btn btn-primary" value="submit">Submit</button>
    </div>
</div>
{{ Form::close() }}
@endsection
