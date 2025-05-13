<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">
</head>
<body>
    <div id="content">
        <h2>Dashboard</h2>

        @if ($user_role == 'Admin')
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
        @else
            @if ($student)
                <div class="cards-container">
                    <div class="row-user">
                        <div class="card-user">
                            <h3>Student Information</h3>
                            <table id="student-details-table">
                                <thead>
                                    <tr>
                                        <th>Student ID:</th>
                                        <td>{{ $student->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Student Name:</th>
                                        <td>{{ $student->full_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Year and Section:</th>
                                        <td>{{ $student->_section }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $student->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone Number:</th>
                                        <td>{{ $student->phone_number }}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <p>No student account created by admin.</p>
            @endif
        @endif
    </div>

    <script src="{{ asset('js/close-msg.js') }}"></script>
</body>
</html>
