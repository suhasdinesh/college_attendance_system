<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
@extends('voyager::master')

@section('content')
    <div class="row">
        
        <form id="form" name="form" class="form" method="POST">
        {{Form::token()}}
        <div class="col col-md-2" align="left">
            <h4 class="bold">{{Form::label('Class')}}</h4>
            <select name="class" id="class_id" class="form-control">
            <option value=""></option>
            @foreach($c_list As $class)
                <option class="form-control" value={{$class->id}}>{{$class->name}}</option>
            @endforeach    
            </select>    
            
        </div>
        <div class="col col-md-2" align="left">
            <h4 >{{Form::label('Student')}}</h4>
            <select class="form-control" name="student" id="student">{{Form::label('Student')}}
            <option value="{{$a=''}}">Select a student</option>
            </select>
        </div>      
        <div class="col col-md-2" align="left">
            <h4 >{{Form::label('Subject')}}</h4>
            <select class="form-control" name="subject" id="subject">{{Form::label('Subject')}}
            <option value="{{$a=''}}">Select a Subject</option>
            </select>
        </div>  
        <div class="col col-md-2" align="left" justify="center" style="margin-top:2.5%;">
            <button class="btn btn-primary" type="submit" id="submit">Submit</button>
        </div>
        {{Form::close()}}       
    </div>
    <div id="table" style="margin-top:3%;">
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script>
                $(document).ready(function(){
                    $('#class_id').change(function(){
                        var class_id = $(this).val();
                        $('#student').find('option').not(':first').remove();
                        $('#subject').find('option').not(':first').remove();
                        // console.log(class_id);
                        $.ajax({
                            url: '/portal/attendance/view/'+class_id,
                            type: 'get',
                            dataType: 'json',
                            success: function(response){
                                var len = 0;
                                if(response != null){
                                    len = response.length;           
                                    console.log(len);            
                                 }
                                // if(len > 0){
                                // Read data and create <option >
                                for(var i=0; i<len; i++){
                                    var id = response[0][i].student_id;
                                    var name = response[0][i].first_name;
                                    var option = "<option value='"+id+"'>"+name+"</option>"; 
                                    $("#student").append(option); 
                                    }
                                for(var i=0; i<len; i++){
                                    var s_id = response[1][i].id;
                                    var name = response[1][i].subject_name;
                                    var option = "<option value='"+s_id+"'>"+name+"</option>"; 
                                    $("#subject").append(option); 
                                }    
                            }
                        })
                    })
                })
</script>

<script>
    $(document).ready(function(){
        $('#submit').click(function(event){
            event.preventDefault();
            console.log('HI');
            $("#table").empty();

            var student=$('#student').val();
            var subject=$('#subject').val();
            
            console.log(student);
            console.log(subject);
            $.ajax({
            url : '/portal/attendance/view',
            type : 'post',
            dataType : 'json',
            data : { 
                "_token" : "{{csrf_token()}}",
                "student_id" : student,
                "subject" : subject,
            },
            success:function(response){
                // console.log('response');
                // alert(response);
                console.log(response);
                var table="<table class='table table-bordered'><tr><th>Date</th><th>Status</th></tr>";
                var status;
                for(var i=0;i<response.length;i++){
                    if(response[i].status==1){
                        var status='Present';
                    }
                    else {
                        var status='Absent';
                    }
                    var data="<tr class='table' id='table'><td>"+response[i].date+"</td><td>"+status+"</td></tr>";
                    table=table+data
                }
                // console.log(data)
                table=table+"</table>"
                $('#table').append(table);
                // console.log(table);

                },
            });
        });
    });
</script>