@extends('voyager::master')

@section('content')
    <!-- <div class="card card-title bg-success"> Attendance Marked Successfully</div> -->
    <table class="table table-bordered">
    <tr><th>Date</th><th>Student_ID</th><th>Status</th></tr>
    
    @foreach($attendance As $att)     
    
        <tr> 
        <td>{{$att['date']}}</td>     
        <td>{{$att['student_id']}}</td>
        <td>@if($att['status']=='1') 
            {{"Present"}}
            @else
            {{'Absent'}}
            @endif   
        </tr>
    @endforeach
    </table>
@endsection()