@extends('voyager::master')

@section('content')

<div class="container" style="width:inherit;">
    <div class="card" style="margin-top: 3%;">
        <div class="card-body" style="background-color: #ededed; box-shadow:snow; ">
            {{ Form::open(['id'=>'form1']) }}
            <div class="row">
                <div class="col-sm-6">
                    <div class="content">
                        <div class="row">
                            <div class="col col-sm-2">
                                <h4>{{ Form::label('Class',null,['class'=>'form-group']) }}
                                </h4>
                            </div>
                            <div class="col col-sm-6">
                                <select class="form-control" name="s_class" id="s_class">
                                    <option value="{{ $a=0 }}">Select a Class</option>
                                    @foreach($c_list as $s_class)
                                        <option value="{{ $s_class ->id }}">{{ $s_class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-2">
                                <h4>{{ Form::label('Student',null,['class'=>'form-group']) }}
                            </div>
                            <div class="col col-sm-6">
                                <select id="student" class="form-control">
                                    <option value="{{ $a=0 }}">Select a student</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-2">
                                <h4>{{ Form::label('Subject',null,['class'=>'form-group']) }}
                            </div>
                            <div class="col col-sm-6">
                                <select id="subject" class="form-control">
                                    <option value="{{ $a=0 }}">Select a subject</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-2">
                                <h4>{{ Form::label('Semester',null,['class'=>'form-group']) }}</h4>
                            </div>
                            <div class="col col-sm-6">
                                {{ Form::text('Semester',null,['class'=>'form-control','id'=>'semester']) }}
                            </div>
                        </div>
                        {{ Form::submit('Fetch Data',['class' => 'btn btn-primary','id'=>'form1_submit']) }}
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="col-sm-6" style="display: none;" id="right_contents">
                    {{ Form::open() }}
                    <div class="row">
                        <div class="col-sm-2" id="rl_1" >
                           <h5>{{Form::label('First Internals')}}</h5>
                            <!-- Right side label - 1 -->
                        </div>
                        <div class="col-sm-6" id="ri_1">
                            <!-- Right Side Input Box 1 -->
                            {{Form::number('test1',null,['class'=>'form-control','id'=>'test1'])}}
                        </div>
                        
                        <div class="col-sm-2" id="rs_1">
                            <!-- Right Side Input Box 1 -->
                            <select class="form-control" id="out_of">
                                Out of
                                <option value="35">35</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2" id="rl_2">
                            <!-- Right Side Label 2 -->
                            <h5>{{Form::label('Second Internals')}}</h5>
                        </div>
                        <div class="col-sm-6" id="ri_2">
                            <!-- Right Side Input 2 -->
                            {{Form::number('test2',null,['class'=>'form-control','id'=>'test2'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2" id="rl_3">
                            <!-- Right Side Label 3 -->
                            <h5>{{Form::label('Assignments')}}</h5>
                        </div>
                        <div class="col-sm-6" id="ri_3">
                            <!-- Right Side Input 3 -->
                            {{Form::number('assignments',null,['class'=>'form-control','id'=>'assignment'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2" id="rl_4">
                            <!-- Right Side Label 4 -->
                            <h5>{{Form::label('Attendance')}}</h5>
                        </div>
                        <div class="col-sm-6" id="ri_4">
                            <!-- Right Side Input 4 -->
                            {{Form::number('attendance',null,['class'=>'form-control','id'=>'attendance'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2" id="rl_5">
                            <!-- Right Side Label 5 -->
                            <h5>{{Form::label('Total')}}</h5>
                        </div>
                        <div class="col-sm-6" id="ri_5">
                            <!-- Right Side Input 5 -->
                            {{Form::number('total',null,['class'=>'form-control disabled','id'=>'total'])}}
                        </div>
                        <div class="col-sm-6" id="ri_5">
                            <!-- Right Side Input 5 -->
                            <button type="button" id="calc" name="calc" class="btn btn-info">Calculate</button>
                        </div>
                    </div>
                    {{Form::submit('Save',['class'=>'btn btn-success','id'=>'save'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>


<script>
    $(document).ready(function () {
        $('#s_class').change(function get_class() {
            var class_id = $('#s_class').val();
            $('#student').find('option').not(':first').remove();
            $('#subject').find('option').not(':first').remove();
            
            $.ajax({
                url: '/portal/internal_assessment/' + class_id,
                type: 'get',
                success: function (response) {
                    console.log(response);
                    for (var i = 0; i < response[0].length; i++) {
                        var option = "<option value=" + response[0][i].student_id + ">" +
                            response[0][i].first_name + "</option>";
                        $('#student').append(option);
                    }
                    for (var i = 0; i < response[1].length; i++) {
                        var option = "<option value=" + response[1][i].id + ">" + response[
                            1][i].subject_name + "</option>";
                        $('#subject').append(option);
                    }

                }
            })
        })


        $('#form1_submit').click(function (event) {
            event.preventDefault();
            var class_id = $('#s_class').val();
            var student_id = $('#student').val();
            var subject_id = $('#subject').val();
            var semester = $('#semester').val();
            
            $('#right_contents').fadeIn();
            $('#total').prop('disabled',true);
            $.ajax({
                url: '/portal/internal_assessments',
                type: 'post',
                dataType: 'json',
                data: {
                    'class_id': class_id,
                    'student_id': student_id,
                    'subject_id': subject_id,
                    'semester': semester,
                },
                success: function (response) {              
             
                    $('#test1').val(response.test1);
                   
                    $('#test2').val(response.test2);
                    var out_of=$('#out_of').val();
                    $('#assignment').val(response.assignment);
                    $('#attendance').val(response.attendance);
                    // $('#total').val(((response.test1+response.test2)/out_of)+response.assignment+response.attendance);                
                }
            })
        })
        $('#calc').click(function(){
                        var out_of=$('#out_of').val();
                        out_of=parseInt(out_of)/10;
                        $('#total').val(0);
                        var test1=$('#test1').val();
                        test1=parseInt(test1);
                        var test2=$('#test2').val();
                        test2=parseInt(test2);
                        var assignment=$('#assignment').val();
                        assignment=parseInt(assignment);
                        var attendance=$('#attendance').val();
                        attendance=parseInt(attendance);
                        $('#total').val(((test1+test2)/out_of)+assignment+attendance);
                    })
        $('#save').click(function(event){
            event.preventDefault();
            var out_of=$('#out_of').val();
            out_of=parseInt(out_of);
            // $('#total').val(0);
            var test1=$('#test1').val();
            test1=parseInt(test1);
            var test2=$('#test2').val();
            test2=parseInt(test2);
            var assignment=$('#assignment').val();
            assignment=parseInt(assignment);
            var attendance=$('#attendance').val();
            attendance=parseInt(attendance);
            var total=$('#total').val();
            total=parseInt(total);
            var class_id = $('#s_class').val();
            var student_id = $('#student').val();
            var subject_id = $('#subject').val();
            var semester = $('#semester').val();
            console.log(out_of);
            $.ajax({
                url : '/portal/internal_assessments/store',
                type : 'POST',
                dataType : 'JSON',
                data : {
                    'class_id' : class_id,
                    'student_id' : student_id,
                    'subject_id' : subject_id,
                    'semester' : semester,
                    'test1' : test1,
                    'test2' : test2,
                    'attendance' : attendance,
                    'assignment' : assignment,
                    'total' : total,
                    'out_of' : out_of,
                },
                success : function(response){
                    if(response){
                        alert("Data Updated Successfully!");
                        location.reload();
                    }
                }
            })
        })

    })

</script>
