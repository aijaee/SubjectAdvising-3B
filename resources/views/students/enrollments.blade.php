<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Enrollments</title>
    <link rel="stylesheet" href="{{ asset('css/common-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/students-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
</head>
<body>
    @include('layouts.sidebar')

    <div id="content">
        <h2>Your Enrollments</h2>
        @if(isset($student) && $student)
            <div style="margin-bottom: 15px; color: #333; background: #f8f9fa; padding: 10px; border-radius: 5px;">
                <strong>Student ID:</strong> {{ $student->student_id }}<br>
                <strong>Name:</strong> {{ $student->full_name }}<br>
                <strong>Email:</strong> {{ $student->email }}
            </div>
        @endif
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert error">
                <ul style="margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="margin-bottom: 20px;">
            <button id="openEnrollmentModalBtn" class="enroll-student-btn" style="padding: 8px 18px; border-radius: 4px; background: #007bff; color: #fff; border: none; cursor: pointer;">
                <i class="fas fa-plus" style="margin-right: 8px;"></i>Add Enrollment
            </button>
        </div>

        <!-- Add Enrollment Modal -->
        <div id="addEnrollmentModal" class="modal">
            <div class="modal-content">
                <span class="close" id="closeEnrollmentModalBtn">&times;</span>
                <h2 style="text-align:center;">Add Enrollment</h2>
                {{-- Debug: Show which student is being used --}}
                <div style="color: #888; font-size: 13px; margin-bottom: 10px;">
                    Modal Student ID: {{ isset($student) && $student ? $student->student_id : 'NOT SET' }}
                </div>
                @if(!isset($student) || !$student)
                    <div style="color: red; margin-bottom: 10px;">
                        Error: No student record found for your account. Please contact admin.
                    </div>
                @endif
                <form action="{{ route('enrollments.store') }}" method="POST" class="form-container" style="display: flex; flex-direction: column; align-items: center;" id="enrollmentForm">
                    @csrf
                    {{-- Student ID: required, from database student --}}
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="student_id">Student ID <span style="color:red">*</span></label>
                        <input type="text" id="student_id" name="student_id"
                            value="{{ isset($student) && $student ? $student->student_id : '' }}"
                            readonly required>
                    </div>
                    {{-- Course ID: show both ID and name in dropdown --}}
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="course_id">Course <span style="color:red">*</span></label>
                        <select id="course_id" name="course_id" required>
                            <option value="">-- Select Course --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->course_id }}" data-name="{{ $course->course_name ?? $course->name }}" {{ old('course_id') == $course->course_id ? 'selected' : '' }}>
                                    [{{ $course->course_id }}] {{ $course->course_name ?? $course->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Enrollment Date --}}
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="enrollment_date">Enrollment Date</label>
                        <input type="date" id="enrollment_date" name="enrollment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    {{-- Enrollment Status: dropdown "Active" or "On Reservation" --}}
                    <div class="form-group" style="width: 100%; max-width: 350px;">
                        <label for="enrollment_status">Enrollment Status <span style="color:red">*</span></label>
                        <select id="enrollment_status" name="enrollment_status" required>
                            <option value="">-- Select Status --</option>
                            <option value="On Reservation">On Reservation</option>
                            <option value="Active">Active</option>
                        </select>
                    </div>
                    <button type="submit" class="enroll-btn" style="width: 100%; max-width: 350px;">Add Enrollment</button>
                </form>
            </div>
        </div>

        {{-- Only show enrollments table, not students --}}
        <table id="enrollments-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Course</th>
                    <th>Course ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @php $enrollments = $enrollments ?? collect(); @endphp
                @forelse($enrollments as $enrollment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ isset($student) && $student ? $student->student_id : '' }}
                        </td>
                        <td>{{ $enrollment->course->course_name ?? 'N/A' }}</td>
                        <td>{{ $enrollment->course_id ?? ($enrollment->course->course_id ?? 'N/A') }}</td>
                        <td>{{ $enrollment->status ?? 'Enrolled' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">No enrollments found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        // Modal logic
        const modal = document.getElementById('addEnrollmentModal');
        const openBtn = document.getElementById('openEnrollmentModalBtn');
        const closeBtn = document.getElementById('closeEnrollmentModalBtn');

        if (openBtn && modal) {
            openBtn.onclick = function() {
                modal.style.display = "block";
            }
        }
        if (closeBtn && modal) {
            closeBtn.onclick = function() {
                modal.style.display = "none";
            }
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Show selected course ID and name (guard for missing elements)
        const courseSelect = document.getElementById('course_id');
        const courseInfoDiv = document.getElementById('selectedCourseInfo');
        const courseIdSpan = document.getElementById('selectedCourseId');
        const courseNameSpan = document.getElementById('selectedCourseName');
        if (courseSelect && courseInfoDiv && courseIdSpan && courseNameSpan) {
            courseSelect.addEventListener('change', function() {
                const selected = courseSelect.options[courseSelect.selectedIndex];
                if (selected.value) {
                    courseInfoDiv.style.display = 'block';
                    courseIdSpan.textContent = selected.value;
                    courseNameSpan.textContent = selected.getAttribute('data-name');
                } else {
                    courseInfoDiv.style.display = 'none';
                    courseIdSpan.textContent = '';
                    courseNameSpan.textContent = '';
                }
            });
        }

        // Debug: log form data before submit
        document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
            const studentId = document.getElementById('student_id').value;
            const courseId = document.getElementById('course_id').value;
            if (!studentId || !courseId) {
                alert('Student ID and Course ID are required!');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>


