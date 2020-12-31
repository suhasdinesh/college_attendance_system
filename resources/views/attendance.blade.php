@extends('voyager::master')

@section('content')
<table class="table table-bordered">
    <tr>
        <th>Name</th>
        <th>Student_ID</th>
        <th>Class</th>
        <th>Status</th>
    </tr>
    @foreach($students As $student)
        <tr>
            <td>{{ $student->first_name }}</td>
            <td>{{ $student->student_id }}</td>
            <td>{{ $student->name }}</td>
            <td>@php echo Form::select('select',['1' => 'Present' , '2' => 'Absent']);@endphp</td>
    @endforeach

    </tr>

</table>
<button class="btn btn-primary" value="submit">Submit</button>
@endsection
