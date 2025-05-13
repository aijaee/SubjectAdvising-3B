<!-- filepath: d:\AcademicFiles\WebDevelopment\SubjectAdvising-3B\resources\views\dashboard\student.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-style.css') }}">
</head>
<body>
@include('layouts.sidebar')

    <div id="content">
        <h2>Student Dashboard</h2>
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
    </div>
</body>
</html>