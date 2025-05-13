<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Student List</h2>

        <!-- Search and Filter -->
        <div class="search-bar">
            <form action="{{ route('students.index') }}" method="GET">
                <input type="text" name="query" placeholder="Search by Student Name..." value="{{ request('query') }}">
                <select name="gender">
                    <option value="">-- Search by Gender --</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <button type="submit" class="search-btn"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>

        <!-- Add New Student Button -->
        <div class="add-student-container">
            <a href="{{ route('students.create') }}" class="enroll-student-btn">Add New Student</a>
        </div>

        <!-- Students Table -->
        <table id="students-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Section</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>
                            @if ($student->picture)
                                <img src="{{ asset('storage/' . $student->picture) }}" alt="Student Picture" width="100">
                            @else
                                <span>No Picture</span>
                            @endif
                        </td>
                        <td>{{ $student->full_name }}</td>
                        <td>{{ $student->date_of_birth }}</td>
                        <td>{{ $student->gender }}</td>
                        <td>{{ $student->_section }}</td>
                        <td>{{ $student->phone_number }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('students.edit', $student) }}" class="edit-btn">
                                     Edit
                                </a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $students->links() }}
        </div>
    </div>
</body>
</html>
