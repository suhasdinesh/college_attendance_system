@extends('voyager::master')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"
    integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ=="
    crossorigin="anonymous" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
    integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
    crossorigin="anonymous"></script>


@section('content')
<div class="card shadow p-3 mb-5 bg-white rounded bg-dark" align="justify"
    style="width:100%;margin-top:2%; background-color: #ededed; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
    <div class="card-body" style="">

        {{ Form::open() }}
        <div class="row">
            <div class="col-sm-2 form-group">
                <h4>{{ Form::label('Class') }}</h4>
            </div>
            <div class="col-sm-6 form-group">
                <select id="s_class" name="s_class" class="form-control">
                    <option class="form-control" value="{{ $a=0 }}"></option>
                    @foreach($c_list as $s_class)
                        <option class="form-control" value="{{ $s_class->id }}">{{ $s_class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-2 form-group">
                <h4>{{ Form::label('Student') }}</h4>
            </div>


            <div class="col-sm-6 form-group">
                <select id="student" name="student_id" class="form-control">
                    <option class="form-control" value="{{ $a=0 }}"></option>
                </select>
            </div>

        </div>
        <div class="row">
            <div class="col-md-4">
                {{ Form::date('From Date',null,['id' => 'date1','class' => 'form-control']) }}
            </div>
            <div class="col-md-4">
                {{ Form::date('From Date',null,['id' => 'date2','class' => 'form-control']) }}
            </div>
        </div>
    </div>

    <button class="btn btn-primary" type="submit" id="submit">Submit</button>
    {{ Form::close() }}
<div style="margin-top: 5%;">
    <div class="row" id="data">
    </div>

</div>

@endsection
<script>
    $(document).ready(function () {
        $('#s_class').change(function () {
            var class_id = $(this).val();
            // console.log(class_id);
            $('#student').find('option').not(':first').remove();
            event.preventDefault();
            $.ajax({
                url: '/portal/attendance/view_single/' + class_id,
                type: 'get',
                success: function (response) {
                    // console.log(response);
                    for (var i = 0; i < response.length; i++) {
                        var option = "<option class='form-control' value=" + response[i]
                            .id +
                            ">" + response[i].first_name + "</option>";
                        $('#student').append(option);
                    }
                }

            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        $('#submit').click(function (event) {
            event.preventDefault();
            // console.log('HI');
            var stu = $('#student').val();
            var from_date = $('#date1').val();
            var to_date = $('#date2').val();
            // console.log([stu,from_date,to_date]);
            $.ajax({
                url: "/portal/attendance/view_single",
                type: "post",
                data: {
                    'student_id': stu,
                    'from_date': from_date,
                    'to_date': to_date,

                },
                success: function (response) {
                    var table;
                    console.log(response);
                    table =
                        "<table width='50%' class='table table-bordered'><tr><th>Date</th><th>Subject</th><th>Status</th></tr>"
                    for (var i = 0; i < response.length; i++) {
                        if (response[i].status == 1) {
                            var status = 'Present';
                        } else {
                            var status = 'Absent';
                        }
                        var data = "<tr><td>" + response[i].date + "</td><td>" + response[i]
                            .subject_name + "</td><td>" + status + "</td></tr>";
                        table = table + data;
                    }
                    $('#data').append(table);

                },

            });

        });
    });

</script>

<script>
    $(document).ready(function ($) {
        $('#date1').datepicker({
            dateFormat: "yy-mm-dd",
        });
        var pickDate;
        $('#date2').datepicker({
            dateFormat: "yy-mm-dd",
        });
        $('#date1').change(function () {
            pickDate = $(this).val();
            $('#date2').datepicker("option", "minDate", pickDate);
            // console.log(pickDate);
        });
    });

</script>
