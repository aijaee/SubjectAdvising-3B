<div id="sidebar">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{ route('students.index') }}"><i class="fas fa-user"></i> Students</a></li>

    </ul>
    <div id="user-info">
        <p>Welcome, {{ session('user_role') }}</p>
        <p><a href="{{ route('logout') }}" class="logout-btn">Logout</a></p>
    </div>
</div>
