<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register-style.css') }}">
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="phone" placeholder="Your Phone Number" required>
            <input type="password" name="password" placeholder="Your Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
            <select name="user_role" required>
                <option value="Student">Student</option>
                <option value="Admin">Admin</option>
            </select>
            <button class="btn" type="submit">Register</button>
            <p class="login-link">Already have an account? <a href="{{ route('login') }}">Login</a></p>
        </form>
    </div>
</body>
</html>