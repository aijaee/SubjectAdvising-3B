<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Reservation System - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>
<body>
    <div class="content">
        <div class="container">
            <h1>Login</h1>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="password" name="password" placeholder="Your Password" required>
                <button type="submit" name="login">Login</button>
                <p class="note">Don't have an account? <a href="{{ route('register') }}" class="link">Register</a></p>
            </form>
        </div>
    </div>
</body>
</html>