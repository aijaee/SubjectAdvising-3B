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
        <form method="POST" action="{{ route('register') }}" id="registerForm">
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
    <script>
        document.getElementById('registerForm').onsubmit = function(e) {
            var pwd = this.password.value;
            var hasLength = pwd.length >= 8;
            var hasNumber = /[0-9]/.test(pwd);
            var hasSpecial = /[^A-Za-z0-9]/.test(pwd);
            if (!(hasLength && hasNumber && hasSpecial)) {
                alert('Password must be at least 8 characters, include a number and a special symbol.');
                e.preventDefault();
            }
        };
    </script>
</body>
</html>