<!-- filepath: d:\AcademicFiles\WebDevelopment\SubjectAdvising-3B\resources\views\dashboard\admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">
</head>
<body>
@include('layouts.sidebar')
    <div id="content">
        <h2>Admin Dashboard</h2>
        <div class="cards-container">
            <div class="row">
                <div class="card">
                    <i class="fas fa-users"></i>
                    <h3>Total Students</h3>
                    <span>{{ $students->count() }}</span>
                </div>
                <div class="card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Total Courses</h3>
                    <span>{{ $courses->count() }}</span>
                </div>
                <div class="card">
                    <i class="fas fa-book-open"></i>
                    <h3>Total Enrollments</h3>
                    <span>{{ $enrollments->count() }}</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>