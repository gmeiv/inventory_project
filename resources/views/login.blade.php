<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/about.css') }}">
</head>
<body>
    @include('layouts.header')

        <div class="container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Login</h1>

                @if($errors->any())
                    <div class="form-group error-box" style="color: red; margin-bottom: 10px;">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif


                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required >
                </div>
                <div class="links"><a href="{{url('/forgot_password')}}">Forgot your password?</a></div>
                <div class="links">Create an Account? <a href="{{ url('/register') }}">Sign Up</a></div>
                <button class="btn_out" type="submit">Log In</button>
            </form>
        </div>
    
</body>
</html>