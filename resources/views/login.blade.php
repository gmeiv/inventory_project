<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Log In</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
</head>
<body>
    @include('layouts.header')
    @include('layouts.error-pop')

        <div class="container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Login</h1>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required >
                </div>
                <div class="links"><a class="links" style="color: white" href="{{url('/forgot_password')}}">Forgot your password?</a></div>
                <div class="links"><p>Create an Account? </p> <a class="links" style="color: white" href="{{ url('/register') }}">Sign Up</a></div>
                <button class="btn_out" type="submit">Log In</button>
            </form>
        </div>
    
    <div class="notification-container" id="notificationContainer"></div>
    <script>
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            
            const icon = type === 'success' ? 'fas fa-check-circle' : 
                        type === 'error' ? 'fas fa-exclamation-circle' : 
                        'fas fa-info-circle';
            
            notification.innerHTML = `
                <div class="notification-content">
                    <i class="${icon} notification-icon"></i>
                    <span class="notification-message">${message}</span>
                </div>
                <button class="notification-close" onclick="removeNotification(this)">&times;</button>
            `;
            
            container.appendChild(notification);
            
            setTimeout(() => {
                removeNotification(notification.querySelector('.notification-close'));
            }, 5000);
        }

        function removeNotification(button) {
            const notification = button.closest('.notification');
            notification.classList.add('removing');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }

        @if (session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif

        @if (session('error'))
            showNotification("{{ session('error') }}", 'error');
        @endif
    </script>
</body>
</html>