@extends('voyager::master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
@section('content')
    
<div class="panel panel-bordered align-items-center">
    <div class="panel-body">
    {{Form::open(['id'=>'class_form'])}}    
    <section class="row mb-5 pb-md-4 ">
        <div class="col-md-1" style="margin-top: 0.6%">
            {{Form::label('s_class','Class')}}
        </div>
        <div class="col-md-5 ">
            <select class="form-select form-control" name="s_class" id="s_class">
            @foreach ($class_list as $class)
                <option value="{{$class->id}}">{{$class->name}}</option>
            @endforeach
            </select>
        </div>
        
    </section>
    <section class="row mb-5 pb-md-4 " >
        <div class="col-md-1">
            {{Form::label('sub','Subject')}}
        </div>
        <div class="col-md-5 ">
            <select class="form-select form-control" name="sub" id="sub">
            <option value="0"></option>
            </select>
        </div>
        <div class="col-md-3">
            {{Form::submit('Fetch Students',['class'=>'btn btn-info','id'=>'fetch'])}}
        </div>
       
    </section>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#class_form').on('submit',function(event){
            event.preventDefault();
            var cl_id=$('#s_class').val();
            $.ajax({
                url: '/portal/internal_assessments/classwise#' + cl_id,
                type : 'GET',
                success : function(response){
                    console.log(response);
                } 
            })
        })
    })
</script>
@endsection