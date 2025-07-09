<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('layouts.header')
    <div class="container">
        <form action="" method="POST">
        <h1>Forgot Password</h1>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button class="btn_out" type="submit">Send Password Reset Link</button>
    </form>
    </div>
</body>
</html>