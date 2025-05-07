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
    {{-- <div id="sidebar">
        <h1>Dashboard</h1>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="students.php"><i class="fas fa-user"></i> Students</a></li>
            <li><a href="courses.php"><i class="fas fa-book"></i> Courses</a></li>    
            <li><a href="enrollments.php"><i class="fas fa-user-graduate"></i> Enrollments</a></li>
            <li><a href="marks.php"><i class="fas fa-tag"></i> Marks</a></li>
            <li><a href="users.php"><i class="fas fa-users"></i> Users</a></li>        
        </ul>
        <div id="user-info">
            <p>Welcome, s</p>
            <p><a href="logout.php" class="logout-btn">Logout</a></p>
        </div>
    </div> --}}

    <div id="content">
        <h2>Dashboard</h2>

        <!-- Admin View -->
        <div class="cards-container">
            <div class="row">
                <div class="card">
                    <i class="fas fa-users"></i>
                    <h3>Total Students</h3>
                    <span>50</span>
                </div>
                <div class="card">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>Total Courses</h3>
                    <span>20</span>
                </div>
                <div class="card">
                    <i class="fas fa-book-open"></i>
                    <h3>Total Enrollments</h3>
                    <span>150</span>
                </div>
            </div>
        </div>

        <!-- Student View -->
        <div class="cards-container">
            <div class="row-user">
                <div class="card-user">
                    <h3>Student Information</h3>
                    <table id="student-details-table">
                        <thead>
                            <tr>
                                <th>Student ID:</th>
                                <td>12345</td>
                            </tr>
                            <tr>
                                <th>Student Name:</th>
                                <td>John Doe</td>
                            </tr>
                            <tr>
                                <th>Year and Section:</th>
                                <td>3B</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>johndoe@example.com</td>
                            </tr>
                            <tr>
                                <th>Phone Number:</th>
                                <td>+1234567890</td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/close-msg.js') }}"></script>
</body>
</html>