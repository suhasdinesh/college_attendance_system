{{-- <html>
    <head>
   
    </head>
<body> --}}
@extends('voyager::auth.master')

@section('content')
<div class="login-container">
    <p>{{ __('Register Below') }}</p>
    {{ Form::open() }}
    <div class="form-group form-group-default" id="nameGroup">
        <label>{{ __('voyager::generic.name') }}</label>
        <div class="controls">
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                placeholder="{{ __('voyager::generic.name') }}" class="form-control" required>
        </div>
    </div>

    <div class="form-group form-group-default" id="emailGroup">
        <label>{{ __('voyager::generic.email') }}</label>
        <div class="controls">
            <input type="text" name="email" id="email" value="{{ old('email') }}"
                placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
        </div>
    </div>

    <div class="form-group form-group-default" id="passwordGroup">
        <label>{{ __('voyager::generic.password') }}</label>
        <div class="controls">
            <input type="password" id="password" name="password"
                placeholder="{{ __('voyager::generic.password') }}" class="form-control" required>
        </div>
    </div>
    <div class="row">
    <button type="submit" class="btn btn-primary login-button" id="register">Register</button>
    {{ Form::close() }}
    </div>
    <div class="row">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

        <div id="result">
            
        </div>
    </div>
</div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
    integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
    crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#register').click(function (event) {
            event.preventDefault();
            $('#result').empty();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            token="{{csrf_token()}}";
            
            $.ajax({
                url: '/register',
                type: 'post',
                dataType: 'json',
                data: {
                    '_token' : token,
                    'name': name,
                    'email': email,
                    'password': password,
                },
                success: function (response) {
                    
                    if (response=='0') {
                
                        var result = 
                            "<div class='card bg-danger'><div class='card-header'>Email ID already exists.</div><div class='card-body'><h6 class='card-text'>The entered email already exists. Please check if you have registered previously.</h6></div></div>";
                        $('#result').append(result).hide().fadeIn();

                    }
                    else if(response=='1'){
                        var result = 
                            "<div class='card bg-success'><div class='card-header'>Account registered successfully!<div class='card-body'>Your account has been registered successfully, <br>contact office for account approval</div></div>";
                        $('#result').append(result);
                    }
                },
            })
        })
    })

</script>
