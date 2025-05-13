<!-- filepath: d:\AcademicFiles\WebDevelopment\SubjectAdvising-3B\resources\views\students\edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Edit Student</h2>
        <form action="{{ route('students.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" value="{{ $student->full_name }}" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $student->date_of_birth }}" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" required>
                    <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label for="_section">Section</label>
                <input type="text" id="_section" name="_section" value="{{ $student->_section }}" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ $student->phone_number }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ $student->email }}" required>
            </div>
            <div class="form-group">
                <label for="picture">Picture</label>
                <input type="file" id="picture" name="picture">
                @if ($student->picture)
                    <img src="{{ asset('storage/' . $student->picture) }}" alt="Student Picture" width="50">
                @endif
            </div>
            <button type="submit" class="enroll-btn">Update Student</button>
        </form>
    </div>
</body>
</html>