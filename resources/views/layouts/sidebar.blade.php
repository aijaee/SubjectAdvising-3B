<div id="sidebar">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="{{ route('students.index') }}"><i class="fas fa-user"></i> Students</a></li>
    </ul>
    <div id="user-info">
        <p>Welcome, {{ session('user_role') }}</p>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</div>
