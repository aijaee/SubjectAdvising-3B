<div id="sidebar">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
        @if($authUser?->user_role === 'Admin')
            <li><a href="{{ route('students.index') }}"><i class="fas fa-user"></i> Students</a></li>
            <li><a href="{{ route('courses.index') }}"><i class="fas fa-user"></i> Courses</a></li>
            <li><a href="{{ route('enrollments.index') }}"><i class="fas fa-user"></i> Enrollments</a></li>
            <li><a href="{{ route('marks.index') }}"><i class="fas fa-user"></i> Marks</a></li>
            <li><a href="{{ route('users.index') }}"><i class="fas fa-user"></i> Users</a></li>
        @elseif($authUser?->user_role === 'Student')
            <li><a href="{{ route('student.enrollments') }}"><i class="fas fa-user"></i> Enrollments</a></li>
            <li><a href="{{ route('student.marks') }}"><i class="fas fa-user"></i> Marks</a></li>
        @endif
    </ul>
    <div id="user-info">
        <p>Welcome, {{ $authUser?->fullname ?? 'Guest' }}</p>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</div>
