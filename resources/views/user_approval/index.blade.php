@extends('voyager::master')
<title>Approve User </title>
@section('content')
        <div class="card">
            {{Form::open(array('method' => 'post'))}}
            <div class="card-body">
                <div class="row">
                    
                    <div class="col-sm-1" style="margin-top: 0.5%">
                    {{Form::label('Email')}}    
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" id="user_email" name="user">
                            @foreach ($users as $user)
                                <option value={{$user['id']}}>{{$user['email']}}</option>
                            @endforeach
                        </select>              
                    </div>
                </div>

                <div class="row" style="margin-top: 1.5%">
                    <div class="col-sm-1" style="margin-top: 0.5%">
                    {{Form::label('User Type')}}    
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" id="user_type" name="role">
                            <option value="App\Student">Student</option>
                            <option value="App\Teacher">Teacher</option>
                            <option value="App\Parent">Parent</option>

                        </select>              
                    </div>
                </div>
                
                <div class="row" style="margin-top: 1.5%">
                    {{Form::submit('Approve',['class'=>'form-control btn btn-primary','style'=>'width:10%','id'=>'ap_btn'] )}}
                </div>
            </div>
            {{Form::close()}}
        </div>
        {{-- {{$st_id=auth()->user()->students[0]['student_id']}} --}}
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        $('#ap_btn').click(function (event){
            event.preventDefault();
            var id=$('#user_email').val();
            var role=$('#user_type').val();
            $.ajax({
                url : '/portal/approve_user',
                type : 'POST',
                data : {
                    'id' : id,
                    'role' : role,
                },
                success: function(response){
                    console.log(response);
                    location.reload(3);
                    alert('User has been Approved');
                },
            })
        })
    })


</script>
