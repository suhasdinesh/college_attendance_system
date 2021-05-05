@extends('voyager::master')
@section('content')
{{ Form::open() }}
<div class="card px-auto" style="max-width: 50%">
    <div class="card-body">
        <div class="card-content">
            {{ Form::label('Select a Class') }}
            <select name="s_class" class="form-control" style="margin-top: 1rem" id="s_class">Select a class
                @foreach($class_list as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
            {{ Form::submit('Submit',['class'=>'form-control btn btn-primary','id'=>'submit','style'=>'max-width : 5rem;margin-top: 1rem;']) }}

        </div>
    </div>
</div>
{{ Form::close() }}
{{-- <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="td-data" type="button"><span>Excel</span></button> --}}
<div id="result">

</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous">
</script>

<script>
    $(document).ready(function () {
        $('#submit').click(function (event) {
            event.preventDefault();
            $('#result').empty();
            var s_class = $('#s_class').val();
            var table =
                "<table id='td-data' class='table table-bordered'><tr><th>Student</th><th>Subject</th><th>Total classes Conducted</th><th>Total Class Attended</th><th>Attendance Percent</th></tr></table>";
            $('#result').append(table).hide().fadeIn();
            $.ajax({
                url: '/portal/attendance/class_wise',
                type: 'POST',
                dataType: 'json',
                data: {
                    's_class': s_class,
                },
                success: function (response) {
                    for (var i = 0; i < response[0].length; i++) {

                        var student_id = response[0][i];
                        // console.log(student_id);
                        var data = "<tr><td>" + student_id +
                            "</td><td><table class='table table-borderless'>";
                        for (var j = 0; j < response[1][0].length; j++) {

                            var td_data = "<tr><td>" + response[1][i][j]['subject_name'] +
                                "</td></tr>";
                            data = data + td_data;
                            // console.log(response[1][i][j]['Total_attended']);
                        }
                        data = data + "</table><td><table class='table table-borderless'>";

                        for (var j = 0; j < response[1][0].length; j++) {
                            td_data = "<tr scope='row'><td colspan='2' scope='col'>" +
                                response[1][i][j]['Total_attended'] + "</td></tr>";
                            data = data + td_data;
                        }
                        data = data + "</table>";
                        data = data + "<td><table class='table table-borderless'>";
                        for (var k = 0; k < response[1][0].length; k++) {
                            td_data = "<tr><td>" + response[1][i][k][
                                'total_classes_conducted'
                            ] + "</tr></td>";
                            data = data + td_data;
                        }
                        data = data + "</table>";
                        data = data + "<td><table class='table table-borderless'>";
                        for (var k = 0; k < response[1][0].length; k++) {
                            td_data = "<tr><td>" + Math.round(response[1][i][k][
                                    'Total_attended'
                                ] / response[1][i][k]['total_classes_conducted'] * 100) +
                                "%</tr></td>";
                            data = data + td_data;
                        }


                        data = data + "</td></tr></table>";


                        // console.log(response);
                        $('#td-data').append(data).hide().fadeIn();
                    }

                }
            })
        })
    })

</script>
<script>
    $(document).ready(function () {
        $('#td-data').DataTable({
            // dom: 'Bfrtip',
            buttons: [
                'excelHtml5',
            ]
        });
    });

</script>
