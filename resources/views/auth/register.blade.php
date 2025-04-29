<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register-style.css') }}">
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="password" name="password" placeholder="Your Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <button class="btn" type="submit">Register</button>
            <p class="login-link">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </form>
    </div>
</body>
</html>